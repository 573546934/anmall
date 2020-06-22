// pages/project/list.js
const app = getApp();
import $http from '../../utils/request';
import regeneratorRuntime from '../../regenerator/runtime.js';
import { $stopWuxRefresher, $stopWuxLoader, $scrollToTop } from '../../components/index';
const filtersMap = ['region', 'area', 'assets_type', 'more'];
const area = {
    label: '项目面积',
    current: null,
    value: [
        { name: '全部', value: { area_min: 0 } },
        { name: '1000以下', value: { area_min: 0, area_max: 1000 } },
        { name: '1000-3000', value: { area_min: 1000, area_max: 3000 } },
        { name: '3000-5000', value: { area_min: 3000, area_max: 5000 } },
        { name: '5000-10000', value: { area_min: 5000, area_max: 10000 } },
        { name: '10000以上', value: { area_min: 10000 } },
    ]
};
let filtersBackUp;
let clearFilter;
let idCopy = 0;
Page({

    /**
     * 页面的初始数据
     */
    data: {
        isIPX: app.globalData.isIPX,
        // tabs: [
        //     { label: '全部', },
        //     { label: '国内资产', international: '0' },
        //     { label: '海外资产', international: '1' },
        //     { label: '大宗租赁', international: '0' },
        // ],
        // list: [],
        // lastPage: null,
        // pageNum: 1,
        tab: 0,
        host: app.globalData.host,
        filterFlag: false,
        filterIndex: false,
        // disabled: false,
        // filterflag: false,
        // filters: null,
        // filterkey: null,
        // filtersMap: null
    },

    /**
     * 生命周期函数--监听页面加载
     */
    async onShow() {
        if (app.globalData.projectId == idCopy) return
        idCopy = app.globalData.projectId;
        wx.showLoading({
            title: '加载中',
            mask: true
        })
        await this.getCategory();
        await this.initData();
        wx.hideLoading()
    },
    tabChange(e) {
        let index = e.detail.current;
        if (index != this.data.tab) {
            this.setData({
                tab: index,
            });
            idCopy = app.globalData.projectId = this.data.category_id[index].id;
            if (!this.data.category_id[index].last_page) {
                this.initData(true);
            }
        };
    },
    getCategory() {
        return new Promise(resolve => {
            $http.get('categorys').then((res) => {
                let { category_id, sx } = res.data, filters = [];
                if (idCopy) {
                    for (let k = 0; k < category_id.length; k++) {
                        if (category_id[k].id == idCopy) {
                            this.setData({
                                tab: k || 0
                            })
                        }
                    }
                }
                sx['region'] = { label: '国家地理', label_current: null, value_current: null, value: [] };
                sx['more'] = { label: '更多条件', value: [] };
                sx['area'] = area;
                for (let k in sx) {
                    if (k.match(/city|country/)) {
                        sx[k]['flag'] = k;
                        sx['region'].value.push(sx[k])
                        delete sx[k]
                    } else if (!k.match(/region|assets_type|more|area/)) {
                        !k.match(/more/) ? sx[k].current = null : null;
                        sx[k]['flag'] = k;
                        sx['more'].value.push(sx[k])
                        delete sx[k]
                    } else if (!k.match(/more|region/)) {
                        sx[k]['flag'] = k;
                        sx[k].current = null;
                    }
                }
                for (let k = 0; k < filtersMap.length; k++) {
                    filters[k] = sx[filtersMap[k]]
                };
                clearFilter = JSON.stringify(filters);
                for (let k = 0; k < category_id.length; k++) {
                    category_id[k].filters = filters;
                }
                this.setData({ category_id })
                resolve(true)
            })
        })
    },
    initData(loading, flag, page_num) {
        return new Promise(resolve => {
            this.setData({ disabled: true });
            page_num = page_num || 1;
            loading ? wx.showLoading({
                title: '加载中',
                mask: true
            }) : null;
            let { category_id, tab } = this.data,
                current = category_id[tab],
                url = `articles?limit=10&category_id=${current.id}&page=${page_num}`, { filters } = category_id[tab],
                f_flag = 0;
            console.log(filters)
            filters.forEach((filter, f_index) => {
                if (f_index == 0) {
                    if (filter.label_current != null) {
                        url += `&${filter.value[filter.label_current].flag}=${filter.value[filter.label_current].value[filter.value_current||0].name}`
                    }
                } else if (f_index && filter.flag && filter.current != null) {
                    url += `&${filter.flag}=${filter.flag=='area'?(JSON.stringify(filter.value[filter.current].value)):(filter.value[filter.current].name)}`
                } else {
                    filter.value.forEach((fil, ind) => {
                        if (fil.current) {
                            url += `&${fil.flag}=${fil.value[fil.current].name}`
                        }
                    })
                }
            })
            $http.get(url).then(res => {
                if (!res.error) {
                    let list = res.data.data;
                    this.setData({
                        [`category_id[${tab}].list`]: flag ? [...category_id[tab].list, ...list] : list,
                        [`category_id[${tab}].last_page`]: res.data.last_page,
                        [`category_id[${tab}].page_num`]: page_num,
                        disabled: false
                    }, () => {
                        loading ? wx.hideLoading() : null;
                    })
                } else {
                    if (this.data.callFlag == 'refresh') {
                        $stopWuxRefresher(true, `#scroll${tab}`);
                    } else if (this.data.callFlag == 'loadmore') {
                        $stopWuxLoader(false, `#scroll${tab}`);
                    };
                    this.setData({ disabled: false })
                }
                resolve(true)
            })
        })
    },
    async loadMore() {
        this.data.callFlag = 'loadmore';
        let { category_id, tab } = this.data;
        if (category_id[tab].page_num < category_id[tab].last_page) {
            let page_num = category_id[tab].page_num;
            await this.initData(false, true, ++page_num)
            $stopWuxLoader(false, `#scroll${tab}`);
        } else {
            $stopWuxLoader(true, `#scroll${tab}`);
        };
    },
    async refreshData() {
        this.data.callFlag = 'refresh';
        await this.initData();
        $stopWuxRefresher(false, `#scroll${this.data.tab}`);
    },
    tapFilter(e) {
        let { index } = e.currentTarget.dataset, { category_id, tab } = this.data;
        filtersBackUp = JSON.stringify(category_id[tab].filters)
        this.setData({
            filterFlag: true,
            [`category_id[${tab}].filterIndex`]: index
        })
    },
    selectRegion(e) {
        let { type, index } = e.currentTarget.dataset, { filterIndex, filters } = this.data.category_id[this.data.tab], { label_current } = filters[filterIndex];
        console.log(index)
        if (type.match(/label/)) {
            this.setData({
                [`category_id[${this.data.tab}].filters[${filterIndex}].label_current`]: label_current == index ? null : String(index),
            })
            let flag = this.data.category_id[this.data.tab].filters[filterIndex].label_current;
            console.log(flag)
            this.setData({
                [`category_id[${this.data.tab}].filters[${filterIndex}].value_current`]: flag?String(0):null,
            })
        } else {
            this.setData({
                [`category_id[${this.data.tab}].filters[${filterIndex}].${type}_current`]: String(index)
            })
        }
    },
    tapNormal(e) {
        let { index, sindex } = e.currentTarget.dataset, { filterIndex } = this.data.category_id[this.data.tab]
        if (!isNaN(index) && !isNaN(sindex)) {
            let current = this.data.category_id[this.data.tab].filters[filterIndex].value[index].current;
            this.setData({
                [`category_id[${this.data.tab}].filters[${filterIndex}].value[${index}].current`]: sindex == current ? null : String(sindex)
            })
        } else {
            let current = this.data.category_id[this.data.tab].filters[filterIndex].current;

            this.setData({
                [`category_id[${this.data.tab}].filters[${filterIndex}].current`]: index == current ? null : String(index)
            })
        }
    },
    async hideModal() {
        this.setData({
            filterFlag: false,
        });
        let { category_id, tab } = this.data;
        let filters = JSON.stringify(category_id[tab].filters);
        if (filters != filtersBackUp) {
            await this.initData(true);
            $stopWuxLoader(false, `#scroll${tab}`);
            $scrollToTop(null, `#scroll${tab}`)
        }
    },
    async clearFilter() {
        this.setData({
            [`category_id[${this.data.tab}].filters`]: JSON.parse(clearFilter)
        })
        await this.hideModal();
    },
    onHide() {
        $stopWuxRefresher(false, `#scroll${this.data.tab}`);
    },
    async delFilter(e) {
        let { item } = e.currentTarget.dataset, { filters } = this.data.category_id[this.data.tab];
        if (item.flag && !item.c_index) {
            filters[item.f_index].current = null;
        } else if (item.flag && item.c_index) {
            filters[item.f_index].value[item.c_index].current = null
        } else if (item.label_current && item.value_current) {
            filters[item.f_index].label_current = null
            filters[item.f_index].value_current = null
        };
        this.setData({
            [`category_id[${this.data.tab}].filters`]: filters
        });
        await this.initData(true);
        $stopWuxLoader(false, `#scroll${this.data.tab}`);
        $scrollToTop(null, `#scroll${this.data.tab}`)
    }
})