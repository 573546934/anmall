const app = getApp();
import $http from '../../utils/request';
import { $stopWuxRefresher, $stopWuxLoader } from '../../components/index';

Page({

    /**
     * 页面的初始数据
     */
    data: {
        tabs: [
            { label: '全部', type: '', list: [], last_page: null, page_num: 1, limit: 10 },
            { label: '租赁', type: 'rent,tenant', list: [], last_page: null, page_num: 1, limit: 10 },
            { label: '买卖', type: 'buy,sell', list: [], last_page: null, page_num: 1, limit: 10 },
        ],
        tab: 0,
        host: app.globalData.host,
        isIPX:app.globalData.isIPX,
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
            mask:true
        }) : null;
        let { tabs, tab } = this.data,
            url = 'demands',
            current = tabs[tab],
            f_flag = 0;
        for (let k in current) {
            if (k.match(/type|limit/) && current[k]) {
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
    toService(){
        wx.navigateTo({
            url:'/pages/mine/service'
        })
    }
})