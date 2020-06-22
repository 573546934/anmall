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
        host: app.globalData.host,
        filterFlag: false,
        filterIndex: false,
        list: [],
        lastPage: null,
        pageNum: 1
        // disabled: false,
        // filterflag: false,
        // filters: null,
        // filterkey: null,
        // filtersMap: null
    },

    /**
     * 生命周期函数--监听页面加载
     */
    async onLoad() {
        wx.showLoading({
            title: '加载中',
            mask: true
        })
        await this.getCategory();
        await this.initData();
        wx.hideLoading()
    },
    getCategory() {
        return new Promise(resolve => {
            $http.get('categorys').then((res) => {
                let { sx } = res.data, filters = [];
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
                this.setData({ filters, callFlag: true })
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
            let url = `articles?limit=10&category_id=5&page=${page_num}`,
                { filters, list } = this.data,
                f_flag = 0;
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
                    let data = res.data.data;
                    this.setData({
                        list: flag ? [...list, ...data] : data,
                        lastPage: res.data.last_page,
                        pageNum: page_num,
                        disabled: false
                    }, () => {
                        loading ? wx.hideLoading() : null;
                    })
                } else {
                    if (this.data.callFlag == 'refresh') {
                        $stopWuxRefresher(true, `#scroll`);
                    } else if (this.data.callFlag == 'loadmore') {
                        $stopWuxLoader(false, `#scroll`);
                    };
                    this.setData({ disabled: false })
                }
                resolve(true)
            })
        })
    },
    async loadMore() {
        this.data.callFlag = 'loadmore';
        let { pageNum, lastPage } = this.data;
        if (pageNum < lastPage) {
            let page_num = pageNum;
            await this.initData(false, true, ++page_num)
            $stopWuxLoader(false, `#scroll`);
        } else {
            $stopWuxLoader(true, `#scroll`);
        };
    },
    async refreshData(flag) {
        this.data.callFlag = 'refresh';
        await this.initData(flag);
        $stopWuxRefresher(false, `#scroll`);
    },
    tapFilter(e) {
        let { index } = e.currentTarget.dataset, { filters } = this.data;
        filtersBackUp = JSON.stringify(filters)
        this.setData({
            filterFlag: true,
            filterIndex: index
        })
    },
    selectRegion(e) {
        let { type, index } = e.currentTarget.dataset, { filterIndex, filters } = this.data, { label_current } = filters[filterIndex];
        if (type.match(/label/)) {
            this.setData({
                [`filters[${filterIndex}].label_current`]: label_current == index ? null : String(index),
            })
            let flag = this.data.filters[filterIndex].label_current;
            this.setData({
                [`filters[${filterIndex}].value_current`]: flag?String(0):null,
            })
        } else {
            this.setData({
                [`filters[${filterIndex}].${type}_current`]: String(index)
            })
        }
    },
    tapNormal(e) {
        let { index, sindex } = e.currentTarget.dataset, { filterIndex, filters } = this.data
        if (!isNaN(index) && !isNaN(sindex)) {
            let current = filters[filterIndex].value[index].current;
            this.setData({
                [`filters[${filterIndex}].value[${index}].current`]: sindex == current ? null : String(sindex)
            })
        } else {
            let current = filters[filterIndex].current;

            this.setData({
                [`filters[${filterIndex}].current`]: index == current ? null : String(index)
            })
        }
    },
    async hideModal() {
        this.setData({
            filterFlag: false,
        });
        let filters = JSON.stringify(this.data.filters);
        if (filters != filtersBackUp) {
            await this.initData(true);
            $stopWuxLoader(false, `#scroll`);
            $scrollToTop(null, `#scroll`)
        }
    },
    async clearFilter() {
        this.setData({
            filters: JSON.parse(clearFilter)
        })
        await this.hideModal();
    },
    async delFilter(e) {
        let { item } = e.currentTarget.dataset, { filters } = this.data;
        if (item.flag && !item.c_index) {
            filters[item.f_index].current = null;
        } else if (item.flag && item.c_index) {
            filters[item.f_index].value[item.c_index].current = null
        } else if (item.label_current && item.value_current) {
            filters[item.f_index].label_current = null
            filters[item.f_index].value_current = null
        };
        this.setData({
            filters
        });
        await this.initData(true);
        $stopWuxLoader(false, `#scroll`);
        $scrollToTop(null, `#scroll`)
    }
})