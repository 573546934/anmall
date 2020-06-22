// pages/index/search.js
const app = getApp();
import $http from '../../utils/request.js';
import regeneratorRuntime from '../../regenerator/runtime.js';
import { $stopWuxRefresher, $stopWuxLoader } from '../../components/index';
Page({

    /**
     * 页面的初始数据
     */
    data: {
        params: null,
        lastPage: null,
        pageNum: 1,
        list: [],
        host: app.globalData.host
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function(options) {
        let { params } = options;
        this.setData({ params })
    },
    search(e) {
        let { value } = e.detail;
        this.setData({ value, list:[] })
        this.initData(true)
    },
    initData(loading, flag, page_num) {
        page_num = page_num || 1;
        loading ? wx.showLoading({
            title: '加载中',
            mask: true
        }) : null;
        let { params, value, list } = this.data;
        $http.get(`${params}?title=${value}&page=${page_num}`).then(res => {
            if (!res.error) {
                let data = res.data.data;
                this.setData({
                    list: flag ? [...list, ...data] : data,
                    lastPage: res.data.last_page,
                    pageNum: page_num,
                }, () => {
                    loading ? wx.hideLoading() : null;
                })
                $stopWuxLoader(false, `#scroll`);
            } else {
                if (this.data.callFlag == 'refresh') {
                    $stopWuxRefresher(true, `#scroll`);
                } else if (this.data.callFlag == 'loadmore') {
                    $stopWuxLoader(false, `#scroll`);
                };
                this.setData({ disabled: false })
            }
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
    clearSearch(){
        this.setData({
            list:[],
            pageNum:1,
            lastPage:null
        })
        $stopWuxLoader(false, `#scroll`);
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