// pages/authen/serviceProvider/companyMsg.js
const app = getApp();
import regeneratorRuntime from '../../regenerator/runtime.js';
import $http from '../../utils/request.js';
import util from '../../utils/util.js';
Page({

    /**
     * 页面的初始数据
     */
    data: {
        array: ['50万~100万', '100万~200万', '200万~500万', '500万~1000万'],
        isAdd: true,
        region: ['广东省', '广州市', '海珠区'],
        companyInfo: {
          companyName: '',//公司全称
          companyScale: '',//公司规模
          companyWebsite: '',//公司网址
          companyCategory: '',//公司类别
          index: 0,
          moneydefault: '请选择',
          citydefault:'请选择',
          companyImgId:'',//图片id
          companyImgSrc:''//链接
        }
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function (options) {
      console.log(options)
      let companyInfo = JSON.parse(options.companyInfo)
      if (companyInfo){
        this.setData({
          companyInfo
        })
      }
      // if (this.data.companyInfo.companyImgSrc!='') {
      //   this.setData({
      //     isAdd: false
      //   })
      // }
    },
    //输入公司全称
    companyName:function(e){
      var regRule = /\ud83c[\udc00-\udfff]|\ud83d[\udc00-\udfff]|[\u2000-\u2fff]| [\ud83c\udc00 -\ud83c\udfff] | [\ud83d\udc00 -\ud83d\udfff] | [\u2600 -\u27ff]/g;
      if (e.detail.value.match(regRule)) {
        wx.showToast({ title: '公司全称不支持表情符', icon: 'none', duration: 3000, mask: true })
        this.setData({ 'companyInfo.companyName': e.detail.value.replace(regRule, "") })
      } else {
        this.setData({ 'companyInfo.companyName': e.detail.value })
      }
    },
    //公司规模
    companyScale:function(e){
      var regRule = /\ud83c[\udc00-\udfff]|\ud83d[\udc00-\udfff]|[\u2000-\u2fff]| [\ud83c\udc00 -\ud83c\udfff] | [\ud83d\udc00 -\ud83d\udfff] | [\u2600 -\u27ff]/g;
      if (e.detail.value.match(regRule)) {
        wx.showToast({ title: '公司规模不支持表情符', icon: 'none', duration: 3000, mask: true })
        this.setData({ 'companyInfo.companyScale': e.detail.value.replace(regRule, "") })
      } else {
        this.setData({ 'companyInfo.companyScale': e.detail.value })
      }
    },
    //公司网址
    companyWebsite:function(e){
      var regRule = /\ud83c[\udc00-\udfff]|\ud83d[\udc00-\udfff]|[\u2000-\u2fff]| [\ud83c\udc00 -\ud83c\udfff] | [\ud83d\udc00 -\ud83d\udfff] | [\u2600 -\u27ff]/g;
      if (e.detail.value.match(regRule)) {
        wx.showToast({ title: '公司网址不支持表情符', icon: 'none', duration: 3000, mask: true })
        this.setData({ 'companyInfo.companyWebsite': e.detail.value.replace(regRule, "") })
      } else {
        this.setData({ 'companyInfo.companyWebsite': e.detail.value })
      }
    },
    //公司类别
    companyCategory: function (e) {
      var regRule = /\ud83c[\udc00-\udfff]|\ud83d[\udc00-\udfff]|[\u2000-\u2fff]| [\ud83c\udc00 -\ud83c\udfff] | [\ud83d\udc00 -\ud83d\udfff] | [\u2600 -\u27ff]/g;
      if (e.detail.value.match(regRule)) {
        wx.showToast({ title: '公司类别不支持表情符', icon: 'none', duration: 3000, mask: true })
        this.setData({ 'companyInfo.companyCategory': e.detail.value.replace(regRule, "") })
      } else {
        this.setData({ 'companyInfo.companyCategory': e.detail.value })
      }
    },
    //注册资本
    companyChange: function (e) {
        let index = e.detail.value
        let array = this.data.array
        this.setData({
          'companyInfo.index':index,
          'companyInfo.moneydefault': array[index]
        })
    },
    //所在城市
    bindRegionChange: function (e) {
        let index = e.detail.value
        console.log('picker发送选择改变，携带值为', e.detail.value)
        this.setData({
          'companyInfo.citydefault': index[0] + "-" + index[1] + "-" + index[2],
        })
    },
  // companyInfo: {
  //   companyName: '',//公司全称
  //   companyScale: '',//公司规模
  //   companyWebsite: '',//公司网址
  //   companyCategory: '',//公司类别
  //   index: 0,
  //   moneydefault: '请选择',
  //   citydefault: '请选择'
  // }
    //点击提交
    onSubmit:function(e){
      let companyInfo = this.data.companyInfo
      if (companyInfo.companyName.replace(/(^s*)|(s*$)/g, "").length == 0) {
        wx.showToast({ title: '公司全称不能为空', icon: 'none', duration: 1000, mask: true })
        return false;
      } 
      // else if (companyInfo.moneydefault == '请选择') {
      //   wx.showToast({ title: '请选择注册资本', icon: 'none', duration: 1000, mask: true })
      //   return false;
      // } else if (companyInfo.citydefault == '请选择') {
      //   wx.showToast({ title: '请选择城市', icon: 'none', duration: 1000, mask: true })
      //   return false;
      // } else if (companyInfo.companyScale.replace(/(^s*)|(s*$)/g, "").length == 0) {
      //   wx.showToast({ title: '公司规模不能为空', icon: 'none', duration: 1000, mask: true })
      //   return false;
      // } else if (companyInfo.companyWebsite.replace(/(^s*)|(s*$)/g, "").length == 0) {
      //   wx.showToast({ title: '公司网址不能为空', icon: 'none', duration: 1000, mask: true })
      //   return false;
      // } else if (companyInfo.companyCategory.replace(/(^s*)|(s*$)/g, "").length == 0) {
      //   wx.showToast({ title: '公司类别不能为空', icon: 'none', duration: 1000, mask: true })
      //   return false;
      // } else if (companyInfo.companyImgSrc == ''){
      //   wx.showToast({ title: '请上传营业执照', icon: 'none', duration: 1000, mask: true })
      //   return false;
      // }
      else{
        var pages = getCurrentPages();
        var currPage = pages[pages.length - 1];   //当前页面
        var prevPage = pages[pages.length - 2];  //上一个页面
        prevPage.setData({ companyInfo: currPage.data.companyInfo })
        wx.navigateBack({ delta: 1 })
      }
    },
    uploadImg(e) {
      // if (this.data.callFlag) return
      let { index } = e.currentTarget.dataset;
      wx.chooseImage({
        count: 1,
        sizeType: ['compressed'],
        success: res => {
          let { tempFilePaths } = res;
          // this.data.callFlag = true
          app.upload('api/uploadImg', tempFilePaths[0], 'file').then(upload => {
            console.log('upload', upload)
            wx.showToast({ title: '上传成功', icon: 'none', duration: 1000, mask: true })
            // this.data.callFlag = false
            if (upload.statusCode == 200) {
              let data = JSON.parse(upload.data);
              this.setData({
                isAdd: false,
                'companyInfo.companyImgSrc': app.globalData.host + data.url,
                'companyInfo.companyImgId': data.id
              });
              console.log('ddd',this.data.companyInfo)
            } else {
              wx.showToast({
                title: '上传失败',
                icon: 'none',
              })
            }
          })
        }
      })
    },

    //点击上传图片
    // uploadImg: function () {
    //     let that = this;
    //     wx.chooseImage({
    //         count: 1, // 默认9
    //         sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
    //         sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
    //         success: res => {
    //             wx.showToast({
    //                 title: '正在上传...',
    //                 icon: 'loading',
    //                 mask: true,
    //                 duration: 1000
    //             })
    //             // 返回选定照片的本地文件路径列表，tempFilePath可以作为img标签的src属性显示图片
    //             let tempFilePaths = res.tempFilePaths;
    //             that.setData({
    //                 isAdd: false,
    //                 imgSrc: tempFilePaths[0]
    //             })
    //         }
    //     })

    // },

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