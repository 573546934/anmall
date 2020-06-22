// pages/community/partner.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    message: [
      {
        icon: '../../images/jg2.png',
        name: '机构',
        enName: 'Institutions',
        id: 'institution'
      },
      {
        icon: '../../images/gr2.png',
        name: '个人',
        enName: 'PERSONAL',
        id: 'person'
      }
    ]
  },
  toSubmitForm(e){
    let type = e.currentTarget.id;
    wx.navigateTo({
      url:`./partnerSubmit?type=${type}`
    })
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