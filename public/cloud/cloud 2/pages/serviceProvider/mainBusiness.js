// pages/authen/serviceProvider/mainBusiness.js
Page({

    /**
     * 页面的初始数据
     */
    data: {
        ckeckedList:[
            {
                class:"交易服务",
                type:0,
                tag: [{ text: "法律服务" }, { text: "评估咨询" }, { text: "财务顾问" }, {text: "市场调研"
                }, { text: "营销策划" }]
            },
            {
                class: "运营管理",
                type: 1,
                tag: [{ text: "法律服务" }, { text: "评估咨询" }, { text: "财务顾问" }, {text: "市场调研"
                }, { text: "营销策划" }, { text: "评估咨询" }, { text: "财务顾问" }, {text: "市场调研"
                    }, { text: "营销策划" }, ]
            },
            {
                class: "运营管理",
                type: 1,
                tag: [{ text: "法律服务" }, { text: "评估咨询" }, { text: "法律服务" }, { text: "评估咨询" },                   { text: "财务顾问" }, {text: "市场调研"
                }, { text: "营销策划" },]
            },
            {
                class: "运营管理",
                type: 1,
                tag: [{ text: "法律服务" }, { text: "评估咨询" }, { text: "财务顾问" }, {
                    text: "市场调研"
                }, { text: "营销策划" },]
            },

        ]
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
    formSubmit:function(e){
      console.log('111',e.detail.value.class0)
      let classes = e.detail.value
      var arr = [].concat(classes.class0,classes.class1,classes.class2,classes.class3)
      
      let str = arr.toString()
      console.log('arr111', str)

      var pages = getCurrentPages();
      var currPage = pages[pages.length - 1];   //当前页面
      var prevPage = pages[pages.length - 2];  //上一个页面
      prevPage.setData({ bussiness: str })
      wx.navigateBack({ delta: 1 })
    },
    checkboxChange:function(e){
        var checked = e.detail.value;
        if (checked.length >= 4) {
            checked.splice(0,1)
            this.setData({
                
            })
            wx.showToast({
                icon:'none',
                title: '最多只能选择4个',
            })
            return false
        }
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