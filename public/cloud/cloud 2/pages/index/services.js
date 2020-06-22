// pages/index/services.js
const app = getApp();
import $http from '../../utils/request';
import regeneratorRuntime from '../../regenerator/runtime.js';
import { $stopWuxRefresher, $stopWuxLoader, $scrollToTop } from '../../components/index';

Page({

    /**
     * 页面的初始数据
     */
    data: {
        host: app.globalData.host,
        disabled: false,
        list: [],
        lastPage: null,
        pageNum: 1,
    },
    initData(loading, flag, page_num) {
        return new Promise(resolve => {
            this.setData({ disabled: true });
            let { list } = this.data;
            page_num = page_num || 1;
            loading ? wx.showLoading({
                title: '加载中',
                mask: true
            }) : null;
            $http.get(`services?page=${page_num}`).then(res => {
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
                    console.log(this.data.list)
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
    async refreshData() {
        this.data.callFlag = 'refresh';
        await this.initData();
        $stopWuxRefresher(false, `#scroll`);
    },
    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function(options) {
      this.initData(true)
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