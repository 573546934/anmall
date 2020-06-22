// pages/propertyOwner/index.js
const app = getApp();
import regeneratorRuntime from '../../regenerator/runtime.js';
import $http from '../../utils/request';
var timer;
Page({

    /**
     * 页面的初始数据
     */
    data: {
        msgList: [
            { msgNum: "第一步", msgText: "公司信息", nav: "/pages/propertyOwner/companyMsg" },
            { msgNum: "第二步", msgText: "联系人信息", nav: "/pages/propertyOwner/contactMsg" },
        ],
        isChecked: false, //是否同意协议
    },
    onLoad(options){
        let { type } = options;
        this.setData({type})
        wx.setNavigationBarTitle({
            title:type.match(/propertyOwner/gi)?'产权方企业信息提交':'资方企业信息提交'
        })
    },
    initData() {
        return new Promise(resolve => {
            $http.get('member').then(res => {
                this.data.token = true
                resolve(true)
            })
        })
    },

    radioClick: function(event) {
        var isChecked = this.data.isChecked;
        this.setData({ "isChecked": !isChecked });

    },
    async submit() {
        let storage = wx.getStorageSync('forms'),
            { isChecked, type } = this.data,
            title;
        if (!storage) {
            title = '请按照步骤完成信息'
        } else if (storage && !storage.company) {
            title = '请填完成公司信息'
        } else if (storage && !storage.person) {
            title = '请填完成联系人信息'
        } else if (!isChecked) {
            title = '请阅读并同意《XXX协议》'
        };
        if (title) {
            wx.showToast({
                title,
                icon: 'none'
            })
            return
        };
        let temps = [],
            imgs = [],
            params = Object.assign(storage.company, storage.person, { type: 'enterprise' });
        for (let k in params) {
            if (params[k] && k.match(/^card|company_license/)) {
                temps.push({ img: params[k], k })
            } else if (params[k] && k.match(/sex/)) {
                params[k] = params[k] == 1 ? '男' : '女'
            }
        };
        await this.initData();
        for (let k = 0; k < temps.length; k++) {
            imgs[k] = app.upload('api/uploadImg', temps[k].img, 'file', temps[k].k);
        }
        Promise.all(imgs).then(items => {
            items = items.filter(v => v.statusCode == 200)
            for (let k = 0; k < items.length; k++) {
                params[items[k].flag] = JSON.parse(items[k].data).id
            }
            $http.post(type, params).then(res => {
                console.log(res)
                if (res.message && !res.error) {
                    wx.showToast({
                        title: res.message,
                        icon: 'none'
                    })
                    timer = setTimeout(() => {
                        wx.navigateBack();
                    })
                }
            })
        })
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
        clearTimeout(timer);
        wx.removeStorageSync('forms')
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