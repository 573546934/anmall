// pages/authen/serviceProvider/blurb.js
Page({

    /**
     * 页面的初始数据
     */
    data: {
      intro:''
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function (options) {
      console.log(options)
      if (options.intro!=''){
        this.setData({
          intro:options.intro
        })
      }
    },
    onInput:function(e){
      var regRule = /\ud83c[\udc00-\udfff]|\ud83d[\udc00-\udfff]|[\u2000-\u2fff]| [\ud83c\udc00 -\ud83c\udfff] | [\ud83d\udc00 -\ud83d\udfff] | [\u2600 -\u27ff]/g;
      if (e.detail.value.match(regRule)) {
        wx.showToast({ title: '公司简介不支持表情符', icon: 'none', duration: 3000, mask: true })
        this.setData({ intro: e.detail.value.replace(regRule, "") })
      } else {
        this.setData({ intro: e.detail.value})
      }
    },
    onSave:function(){
      if(this.data.intro == ''){
        wx.showToast({ title: '公司简介不能为空', icon: 'none', duration: 3000, mask: true })
      }else{
        var pages = getCurrentPages();
        var currPage = pages[pages.length - 1];   //当前页面
        var prevPage = pages[pages.length - 2];  //上一个页面
        prevPage.setData({ intro: currPage.data.intro })
        wx.navigateBack({ delta: 1 })
      }
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