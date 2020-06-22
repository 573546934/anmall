// pages/news/detail.js
const app = getApp();
import $http from '../../utils/request.js';
import util from '../../utils/util.js';
Page({

    /**
     * 页面的初始数据
     */
    data: {
        id: null,
        data: null,
        article: null,
        host: app.globalData.host,
        isIPX: app.globalData.isIPX
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function(options) {
        let { id } = options;
        this.setData({ id });
        this.initData();
    },
    initData() {
        wx.showLoading({ title: '加载中' })
        return new Promise(resolve => {
            $http.get(`news?id=${this.data.id}`).then(res => {
                let { data } = res, article = null;
                if (data.content) {
                    article = app.towxml.toJson(
                        data.content, // `markdown`或`html`文本内容
                        'html' // `markdown`或`html`
                    );
                    article = app.towxml.initData(article, {
                        base: app.globalData.host,
                        app: this
                    })
                }
                wx.setNavigationBarTitle({ title: data.title })
                this.setData({ data, article })
                resolve(data)
                wx.hideLoading();
            })
        })
    },
    tapPrevNext(e) {
        let flag = e.currentTarget.id,
            item = this.data.data[flag];
        if (item) {
            wx.redirectTo({
                url: `./detail?id=${item.id}`
            })
        }
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
        return util.shareMiniProgram();
    }
})