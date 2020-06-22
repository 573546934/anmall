// pages/authen/serviceProvider/serviceDesc.js
Page({

    /**
     * 页面的初始数据
     */
    data: {
        addDesc: [{ text: "税务策划" }, { text: "" }, { text: "" }]
        
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function (options) {
      console.log(options)
      this.setData({
        addDesc: JSON.parse(options.addDesc)
      })
    },
    oninput:function(e){
      let index = e.target.dataset.index
      let addDesc = this.data.addDesc
      addDesc[index].text = e.detail.value
      this.setData({
        addDesc
      })
    },
    addDesc:function(e){
        var that = this;
        let newArray = { text: "" }
        that.setData({
            addDesc: that.data.addDesc.concat(newArray),
        })
    },
    onSave:function(e){
      var pages = getCurrentPages();
      var currPage = pages[pages.length - 1];   //当前页面
      var prevPage = pages[pages.length - 2];  //上一个页面
      prevPage.setData({ addDesc: currPage.data.addDesc })
      wx.navigateBack({ delta: 1 })
    },
   
    formSubmit:function(e){
        console.log(e);
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