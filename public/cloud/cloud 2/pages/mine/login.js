// pages/mine/login.js
const app = getApp();
import $http from '../../utils/request';
Page({

    /**
     * 页面的初始数据
     */
    data: {
        isIPX: app.globalData.isIPX,
        select: false
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function(options) {

    },
    toggleSelect() {
        this.setData({
            select: !this.data.select
        })
    },
    tapBtn(e) {
        let { flag } = e.currentTarget.dataset;
        if (flag.match(/cancel/)) {
            wx.navigateBack()
        } else {
            if (!this.data.select) {
                wx.showToast({
                    title: '请先阅读并同意《用户使用协议》《隐私协议》',
                    icon: 'none'
                })
            }
        }
    },
    getUserInfo(e) {
        let { userInfo } = e.detail;
        console.log(userInfo)
        if (userInfo) {
            this.updateUserInfo(userInfo)
        } else {
            wx.showToast({
                title: '您已取消授权',
                icon: 'none'
            })
        };
    },
    updateUserInfo(userInfo) {
        let { nickName, avatarUrl } = userInfo, { member } = this.data;
        wx.showLoading({ title: '加载中', mask: true })
        $http.post('member', { nickname: nickName, avatar: avatarUrl }).then(res => {
            wx.hideLoading();
            wx.navigateBack()
            // if (res.data) {
            //     member.nickname = nickName;
            //     member.avatar = avatarUrl;
            //     this.setData({ member })
            // }
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