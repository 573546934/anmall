// pages/index/city.js
const app = getApp();
import $http from '../../utils/request';
Page({

    /**
     * 页面的初始数据
     */
    data: {
        isIPX: app.globalData.isIPX,
        city:null,
        citys:[]
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function(options) {
        let { current } = options;
        let city = current || '北京市'
        this.setData({ city });
        this.getCity();
    },
    setLocation() {
        app.needGetLocationAuth().then(res => {
            if (res) {
                app.getLocation().then(res => {
                    if (res) {
                        let { city } = res.ad_info;
                        this.setData({ city })
                    } else {
                        wx.showToast({
                            title: '获取位置失败！',
                            icon: 'none'
                        })
                    }
                })
            }
        })
    },
    tapCity(e){
      let { city } = e.currentTarget.dataset;
      this.setData({city:city.name}, ()=>{
        this.navBack()
      })
    },
    navBack(){
        wx.navigateBack()
    },
    getCity(){
        $http.get('categorys').then(res=>{
            let { city } = res.data.sx;
            let citys = city.value || [];
            this.setData({citys})
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
        let pages = getCurrentPages();
        if (pages.length > 1) {
            let prePage = pages[pages.length - 2];
            prePage.setData({
                city: this.data.city
            })
        }
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