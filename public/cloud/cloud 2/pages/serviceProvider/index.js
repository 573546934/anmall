// pages/authen/serviceProvider/index.js
const app = getApp();
import regeneratorRuntime from '../../regenerator/runtime.js';
import $http from '../../utils/request.js';
import util from '../../utils/util.js';
Page({

    /**
     * 页面的初始数据
     */
    data: {
        msgList: [
            { msgNum: "第一步", msgText: "公司信息", nav: "/pages/serviceProvider/companyMsg" },
            { msgNum: "第二步", msgText: "业务描述", nav: "/pages/serviceProvider/serviceDesc" }, 
            { msgNum: "第三步", msgText: "主营业务", nav: "/pages/serviceProvider/mainBusiness" }, 
            { msgNum: "第四步", msgText: "公司简介", nav: "/pages/serviceProvider/blurb" },
            { msgNum: "第五步", msgText: "服务案例", nav: "/pages/serviceProvider/case" },
            { msgNum: "第六步", msgText: "联系人信息", nav: "/pages/serviceProvider/contactMsg" },
        ],
        isChecked: false,//是否同意协议
        companyInfo: {
          companyName: '',//公司全称
          companyScale: '',//公司规模
          companyWebsite: '',//公司网址
          companyCategory: '',//公司类别
          index: 0,
          moneydefault: '请选择',
          citydefault: '请选择',
          companyImgId: '',//图片id
          companyImgSrc: ''//链接
        },//公司信息
        addDesc: [{ text: "税务策划" }, { text: "" }, { text: "" }],//业务描述
        bussiness:'',//主营业务
        intro:'',//公司简介
        person: {
          name: '',
          sex: '',
          tel: '',
          city: '请选择',
          company: '请选择',
          index: 0,
          position: '',
          img: '',
          imgId: ''
        }
    },

    /**
     * 生命周期函数--监听页面加载
     */
     onLoad: function (options) {
      //await initData()
      //  this.init()
    },
    jumpPage:function(e){
      console.log(e)
      let { nav,num } = e.target.dataset
      if (num == '第一步'){
        wx.navigateTo({ url: e.target.dataset.nav + "?companyInfo=" + JSON.stringify(this.data.companyInfo)})  
      } else if (num == '第二步'){
        wx.navigateTo({ url: e.target.dataset.nav + "?addDesc=" + JSON.stringify(this.data.addDesc) })
      } else if (num == '第三步'){
        wx.navigateTo({ url: e.target.dataset.nav})
        // wx.navigateTo({ url: e.target.dataset.nav + "?addDesc=" + JSON.stringify(this.data.addDesc) })
      } else if (num == '第四步'){
        wx.navigateTo({ url: e.target.dataset.nav+"?intro="+this.data.intro })
      } else if (num == '第五步'){
        wx.navigateTo({ url: e.target.dataset.nav + "?intro=" + this.data.intro })
      } else if (num == '第六步') {
        wx.navigateTo({ url: e.target.dataset.nav + "?person=" + JSON.stringify(this.data.person) })
      }
      
    },
    onSubmit:function(){
      // let params={
      //   'id_img[0]':th
      // }

      // $http.post('demand', params).then(res => {
      //   // wx.hideLoading();
      //   // if (!res.error && res.message) {
      //   //   wx.showModal({
      //   //     content: res.message,
      //   //     confirmText: '查看需求',
      //   //     cancelText: '关闭',
      //   //     success: modal => {
      //   //       if (modal.confirm) {
      //   //         wx.redirectTo({
      //   //           url: '/pages/demand/list'
      //   //         })
      //   //       } else if (modal.cancel) {
      //   //         wx.navigateBack({
      //   //           delta: 3
      //   //         })
      //   //       }
      //   //     }
      //   //   })
      //   // }
      // })
    },  
    async init() {
      await this.getList()  // 请求数据
    },
     getList() {
      return new Promise(resolve => {
        // let url = `article?id=${this.data.id}`;
        // if (this.data.friend_id) {
        //   url += `&friend_id=${this.data.friend_id}`
        // }
        // console.log(url)
       // `getShare?id=${this.data.id}&path=pages/project/detail`
        $http.get('service').then(res => {
          console.log('结果',res)
          // let { data } = res, article = null;
          // data.type = 'init'
          // if (data.content) {
          //   wx.setNavigationBarTitle({ title: data.title })
          //   article = app.towxml.toJson(
          //     data.content, // `markdown`或`html`文本内容
          //     'html' // `markdown`或`html`
          //   );
          //   article = app.towxml.initData(article, {
          //     base: app.globalData.host,
          //     app: this
          //   })
          // }

          // data.map = data.map || [];
          // data.img ? data.map.push(data.img) : null;
          // data.collection = data.collection;
          // this.setData({ data, article, hasChanged: data.collection })
          // console.log(this.data.data)
          resolve(true)
        })
      })

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
      console.log(this.data.bussiness)
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