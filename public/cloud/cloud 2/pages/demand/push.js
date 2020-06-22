// pages/demand/push.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    message: [
      {
        icon: '../../images/qy.png',
        name: '企业',
        enName: 'ENTERPRISE',
        id: 'enterprise'
      },
      {
        icon: '../../images/gr.png',
        name: '个人',
        enName: 'PERSONAL',
        id: 'personal'
      }
    ]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

  },
  // toSubmitForm(e){
  //   let flag = e.currentTarget.id;
  //   wx.navigateTo({
  //     url:`./type?type=${flag}`
  //   })
  // },
  toSubmit(e) {
    let { flag } = e.currentTarget.dataset;
    wx.navigateTo({
      url: `./form?flag=${flag}`
    })
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  }
})