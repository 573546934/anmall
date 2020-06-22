// pages/news/index.js
const app = getApp();
import $http from '../../utils/request.js';
import { $stopWuxRefresher, $stopWuxLoader } from '../../components/index';
Page({

    /**
     * 页面的初始数据
     */
    data: {
        tabs: [
            { label: '全部', list: [], last_page: null, page_num: 1, limit: 10 },
            { label: '云资讯', category: '云资讯', list: [], last_page: null, page_num: 1, limit: 10 },
            { label: '云资产', category: '云资产', list: [], last_page: null, page_num: 1, limit: 10 },
        ],
        tab: 0,
        host: app.globalData.host,
        disabled: false
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function(options) {
        this.initData(true);
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
    initData(loading, flag, page_num) {
        this.setData({ disabled: true });
        page_num = page_num || 1;
        loading ? wx.showLoading({
            title: '加载中',
            mask:true
        }) : null;
        let { tabs, tab } = this.data,
            url = 'newsList',
            current = tabs[tab],
            f_flag = 0;
        for (let k in current) {
            if (k.match(/category|limit/) && current[k]) {
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
    /**
     * 生命周期函数--监听页面初次渲染完成
     */
    onReady: function() {

    },

    /**
     * 生命周期函数--监听页面显示
     */
    onShow: function() {

    },

    /**
     * 生命周期函数--监听页面隐藏
     */
    onHide: function() {

    },

    /**
     * 生命周期函数--监听页面卸载
     */
    onUnload: function() {

    },

    /**
     * 页面相关事件处理函数--监听用户下拉动作
     */
    onPullDownRefresh: function() {

    },

    /**
     * 页面上拉触底事件的处理函数
     */
    onReachBottom: function() {

    },

    /**
     * 用户点击右上角分享
     */
    onShareAppMessage: function() {

    }
})