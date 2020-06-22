// pages/mine/publish.js
const app = getApp();
import $http from '../../utils/request';
import { $stopWuxRefresher, $stopWuxLoader } from '../../components/index';

Page({

    /**
     * 页面的初始数据
     */
    data: {
        tabs: [
            { label: '已审核', status: '1', list: [], last_page: null, page_num: 1, limit: 10 },
            { label: '未通过', status: '-1', list: [], last_page: null, page_num: 1, limit: 10 },
            { label: '审核中', status: '0', list: [], last_page: null, page_num: 1, limit: 10 },
        ],
        typeMaps: {
            buy: '买',
            sell: '卖',
            rent: '出租',
            tenant: '求租'
        },
        tab: 0,
        host: app.globalData.host,
        disabled: false
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function(options) {
        this.setData({
            tab: options.tab || 0
        });
        if (this.data.tab == 0) this.initData(true)
    },
    initData(loading, flag, page_num) {
        this.setData({ disabled: true });
        page_num = page_num || 1;
        loading ? wx.showLoading({
            title: '加载中',
            mask: true
        }) : null;
        let { tabs, tab } = this.data,
            url = 'mydemands',
            current = tabs[tab],
            f_flag = 0;
        for (let k in current) {
            if (k.match(/status|limit/) && current[k]) {
                url += `${!f_flag?'?':'&'}${k}=${current[k]}`;
                f_flag++;
            }
        }
        url += `&page=${page_num}`;
        return new Promise(resolve => {
            $http.get(url).then(res => {
                if (!res.error) {
                    let list = res.data.data,
                        { tabs, tab } = this.data;
                    this.setData({
                        [`tabs[${tab}].list`]: flag ? [...tabs[tab].list, ...list] : list,
                        [`tabs[${tab}].last_page`]: res.data.last_page,
                        [`tabs[${tab}].page_num`]: page_num,
                        disabled: false
                    }, () => {
                        loading ? wx.hideLoading() : null;
                        resolve(!!list.length)
                    })
                } else {
                    if (this.data.callFlag == 'refresh') {
                        $stopWuxRefresher(true, `#scroll${tab}`);
                    } else if (this.data.callFlag == 'loadmore') {
                        $stopWuxLoader(false, `#scroll${tab}`);
                    };
                    this.setData({ disabled: false })
                }
            })
        })
    },
    tabChange(e) {
        let index = e.detail.current;
        if (index != this.data.tab) {
            this.setData({
                tab: index,
            });
            if (!this.data.tabs[index].last_page) {
                this.initData(true);
            }
        };
    },
    swiperChange(e) {
        let tab = e.detail.current,
            { tabs } = this.data;
        this.setData({ tab });
        if (!tabs[tab].last_page)
            this.initData(true);
    },
    loadMore() {
        this.data.callFlag = 'loadmore';
        let { tabs, tab } = this.data;
        if (tabs[tab].page_num < tabs[tab].last_page) {
            let page_num = tabs[tab].page_num;
            this.initData(false, true, ++page_num).then(() => {
                $stopWuxLoader(false, `#scroll${tab}`);
            })
        } else {
            $stopWuxLoader(true, `#scroll${tab}`);
        };
    },
    refreshData() {
        this.data.callFlag = 'refresh';
        this.initData().then(res => {
            $stopWuxRefresher(false, `#scroll${this.data.tab}`);
        })
    },
    editDemand(e) {
        let { item } = e.currentTarget.dataset;
        if (item.status == -1) {
            wx.navigateTo({
                url: `./edit?id=${item.id}`
            })
        }
    },
    toService(){
        wx.navigateTo({
            url:'/pages/demand/push'
        })
    }
})