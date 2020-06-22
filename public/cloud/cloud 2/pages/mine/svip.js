// pages/mine/svip.js
const app = getApp();
import $http from '../../utils/request.js';
Page({

    /**
     * 页面的初始数据
     */
    data: {
        tabs: [
            { label: '成为超级VIP', title: '成为超级vip' },
            { label: '成为高级合伙人', title: '成为高级合伙人' },
        ],
        tab: 0
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function(options) {
        this.initData()
    },
    initData() {
        $http.get(`raiders?title=${this.data.tabs[this.data.tab].title}`).then(res => {
            let { data } = res, { tab, tabs } = this.data, article;
            if (data.content) {
                article = app.towxml.toJson(
                    data.content, // `markdown`或`html`文本内容
                    'html' // `markdown`或`html`
                );
                article = app.towxml.initData(article, {
                    base: app.globalData.host,
                    app: this
                })
                tabs[tab]['article'] = article;
            }
            this.setData({
                tabs
            })
        })
    },
    tabChange(e) {
        let index = e.detail.current;
        if (index != this.data.tab) {
            this.setData({
                tab: index,
            });
            if (!this.data.tabs[index].article) {
                this.initData();
            }
        };
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