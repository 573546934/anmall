// pages/authen/serviceProvider/contactMsg.js
const app = getApp();
import regeneratorRuntime from '../../regenerator/runtime.js';
import $http from '../../utils/request.js';
import util from '../../utils/util.js';
Page({

    /**
     * 页面的初始数据
     */
    data: {
        array: ['谷歌', '阿里', '百度', '腾讯'],
        // index: 0,
        // default: '请选择',
        // citydefault: '请选择',
        isAdd: true,
        region: ['广东省', '广州市', '海珠区'],


      person:{
        name:'',
        sex:'',
        tel:'',
        city:'请选择',
        company:'请选择',
        index:0,
        position:'',
        img:'',
        imgId:''
      }
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function (options) {
      
      let person = JSON.parse(options.person)
      
      // if (person) {
        this.setData({
          person
        })
        if(this.data.person.img!=''){
          this.setData({
            isAdd:false
          })
        }
      console.log(this.data.person)
      // }
    },
    //电话
    tel: function (e) {
      var regRule = /\ud83c[\udc00-\udfff]|\ud83d[\udc00-\udfff]|[\u2000-\u2fff]| [\ud83c\udc00 -\ud83c\udfff] | [\ud83d\udc00 -\ud83d\udfff] | [\u2600 -\u27ff]/g;
      if (e.detail.value.match(regRule)) {
        wx.showToast({ title: '电话不支持表情符', icon: 'none', duration: 3000, mask: true })
        this.setData({ 'person.tel': e.detail.value.replace(regRule, "") })
      } else {
        this.setData({ 'person.tel': e.detail.value })
      }
    },
    //职务
    position: function (e) {
      var regRule = /\ud83c[\udc00-\udfff]|\ud83d[\udc00-\udfff]|[\u2000-\u2fff]| [\ud83c\udc00 -\ud83c\udfff] | [\ud83d\udc00 -\ud83d\udfff] | [\u2600 -\u27ff]/g;
      if (e.detail.value.match(regRule)) {
        wx.showToast({ title: '职务不支持表情符', icon: 'none', duration: 3000, mask: true })
        this.setData({ 'person.position': e.detail.value.replace(regRule, "") })
      } else {
        this.setData({ 'person.position': e.detail.value })
      }
    },
    //姓名
    name: function (e) {
      var regRule = /\ud83c[\udc00-\udfff]|\ud83d[\udc00-\udfff]|[\u2000-\u2fff]| [\ud83c\udc00 -\ud83c\udfff] | [\ud83d\udc00 -\ud83d\udfff] | [\u2600 -\u27ff]/g;
      if (e.detail.value.match(regRule)) {
        wx.showToast({ title: '姓名不支持表情符', icon: 'none', duration: 3000, mask: true })
        this.setData({ 'person.name': e.detail.value.replace(regRule, "") })
      } else {
        this.setData({ 'person.name': e.detail.value })
      }
    },
    //公司
    companyChange: function (e) {
        let index = e.detail.value
        let array = this.data.array
        this.setData({
            'person.index':index,
            'person.company': array[index]
        })
    },
    //性别
  sexChange:function(e){
    //radio改变选中的时候
    this.setData({ 'person.sex': e.detail.value })
  },
  //城市
    bindRegionChange: function (e) {
        let index = e.detail.value
        console.log('picker发送选择改变，携带值为', e.detail.value)
        this.setData({
          'person.city': index[0] + "-" + index[1] + "-" + index[2],
        })
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
                'person.img': app.globalData.host + data.url,
                'person.imgId': data.id
              });
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
  //点击提交
  onSubmit: function (e) {
    // let companyInfo = this.data.companyInfo
    // if (companyInfo.companyName.replace(/(^s*)|(s*$)/g, "").length == 0) {
    //   wx.showToast({ title: '公司全称不能为空', icon: 'none', duration: 1000, mask: true })
    //   return false;
    // } else if (companyInfo.moneydefault == '请选择') {
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
    // } else if (companyInfo.companyImgSrc == '') {
    //   wx.showToast({ title: '请上传营业执照', icon: 'none', duration: 1000, mask: true })
    //   return false;
    // } else {
      var pages = getCurrentPages();
      var currPage = pages[pages.length - 1];   //当前页面
      var prevPage = pages[pages.length - 2];  //上一个页面
      prevPage.setData({ person: currPage.data.person })
      wx.navigateBack({ delta: 1 })
    // }
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