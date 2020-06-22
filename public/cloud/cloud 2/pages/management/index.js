// pages/authen/management/index.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
      msgList: [
          { msgNum: "第一步", msgText: "公司信息", nav: "./companyMsg" },
          { msgNum: "第二步", msgText: "联系人信息", nav:"./contactMsg" },
      ],
      isChecked:false,   //是否同意协议
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

    radioClick: function (event) {
        var isChecked = this.data.isChecked;
        this.setData({ "isChecked": !isChecked });

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