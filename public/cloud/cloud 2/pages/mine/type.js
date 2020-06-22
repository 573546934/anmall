// pages/community/partner.js
Page({

    /**
     * 页面的初始数据
     */
    data: {
      message:[
        {
          icon: '../../images/qy.png',
          name:'企业',
          enName:'ENTERPRISE',
          id:'enterprise'
        },
        {
          icon: '../../images/gr.png',
          name: '个人',
          enName: 'PERSONAL',
          id:'personal'
        }
      ]
    },
    toSubmitForm(e) {
        let type = e.currentTarget.id,
            url, { action } = this.data;
        console.log(type)
        console.log(action)
        if (type.match(/personal/)) {
            url = `./certification?action=${action}&type=personal`
        } else if (action.match(/^owner|propertyOwner$$/gi)) {
            url = `/pages/propertyOwner/index?type=${action}`
        }
        console.log(url)
        url ? wx.navigateTo({
            url
        }) : null
    },
    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function(options) {
        let { action } = options;
        wx.setNavigationBarTitle({ title: `${action.match(/^owner$/)?'资方':'产权方'}信息` })
        this.setData({ action })
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