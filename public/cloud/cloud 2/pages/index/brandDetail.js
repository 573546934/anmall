// pages/index/brandDetail.js
const app = getApp();
import $http from '../../utils/request';
Page({

  /**
   * 页面的初始数据
   */
  data: {
    data:null,
    host: app.globalData.host,
    isIPX:app.globalData.isIPX
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    let { id } = options;
    this.setData({id})
    this.initData()
  },
  initData(){
    $http.get(`brand?id=${this.data.id}`).then(res=>{
      let { data}= res;
      data.articles = data.articles || [];
      data.articles.forEach((v,i)=>{
        // console.log(v)
        data.articles[i] = v.article;
      })
      this.setData({data})
      wx.setNavigationBarTitle({ title: data.company_name })
      console.log(res)
    })
  },
  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {

  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  }
})