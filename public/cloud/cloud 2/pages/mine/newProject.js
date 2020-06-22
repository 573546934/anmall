// pages/mine/newProject.js
import $http from '../../utils/request';
const app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    isIPX:false,
    categorySelect:-1,
    citySelect:-1,
    countrySelect:-1,
    form:{
      attributes:{
        label:'资产属性',
        value:null,
      },
      location:{
        label:'区位',
        value:null,
      },
      project:{
        label:'项目',
        value:null,
      },
      area:{
        label:'面积',
        value:null,
      },
      offer:{
        label:'报价',
        value:null,
      },
      point:{
        label:'买点',
        value:null,
      },
      debt:{
        label:'债务情况',
        value:null,
      },
      description:{
        label:'详细描述',
        value:null,
      },
      phone:{
        label:'联系方式',
        value:null,
      },
    }
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.setData({isIPX:app.globalData.isIPX});
    this.getCategory();
  },
  getCategory(){
    $http.get('categorys').then(res=>{
      for(let k in res.data){
        this.setData({
          [k]:res.data[k]
        })
      }
      console.log(this.data)
    })
  },
  pickerChange(e){
    let {type} = e.currentTarget.dataset,
        {value} = e.detail;
    this.setData({
      [type]:value
    })
    console.log(e)
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