// pages/mine/feedback.js
const app = getApp();
import $http from '../../utils/request';
Page({

    /**
     * 页面的初始数据
     */
    data: {
        score: 0,
        content: null
    },
    rateFun(e) {
        let { index } = e.currentTarget.dataset;
        this.setData({ score: index })
    },
    syncInput(e) {
        this.setData({
            content: e.detail.value
        })
    },
    submit() {
        let { score, content } = this.data;
        if (!content) {
            wx.showToast({
                title: '请填写您的问题和建议，感谢您的支持〜',
                icon: 'none'
            })
            return
        }
        $http.post('opinion', { score, content }).then(res => {
            if (!res.error && res.message) {
                wx.showModal({
                    content: res.message,
                    showCancel:false,
                    confirmText:'关闭'
                })
            }
        })
    },
    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function(options) {

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