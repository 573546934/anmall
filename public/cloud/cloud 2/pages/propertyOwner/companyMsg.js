// pages/authen/propertyOwner/companyMsg.js
const app = getApp()
import data from '../../utils/city.js';
import regeneratorRuntime from '../../regenerator/runtime.js';
import $http from '../../utils/request';
Page({

    /**
     * 页面的初始数据
     */
    data: {
        form: [
            { label: '公司全称', flag: 'company_name', value: '', require: true },
            { label: '公司所在城市', flag: 'company_city', value: '', require: true },
            { label: '注册资本', flag: 'reg_capital', value: '' },
            { label: '企业网址', flag: 'company_web', value: '' },
            {
                label: '上传营业执照',
                value: '',
                tips: '仅限jpg,png,jpeg,gif格式，文件大小不超过2M',
                flag: 'company_license',
            },
        ],
        data: data,
        host: app.globalData.host
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function(options) {
        let { company } = wx.getStorageSync('forms'), { form } = this.data;
        if (company) {
            for (let k = 0; k < form.length; k++) {
                form[k].value = company[form[k].flag]
            };
            this.setData({ form })
        }
    },
    initData() {
        return new Promise(resolve => {
            $http.get('member').then(res => {
                resolve(true)
            })
        })
    },
    uploadFun(e) {
        if (this.data.callFlag) return
        // this.data.callFlag = true
        let { index } = e.currentTarget.dataset;
        wx.chooseImage({
            count: 1,
            sizeType: ['compressed'],
            success: async (res) => {
                let { tempFilePaths } = res;
                this.setData({
                    [`form[${index}].value`]: tempFilePaths[0]
                });
                // this.data.callFlag = false;
                // await this.initData();
                // app.upload('api/uploadImg', tempFilePaths[0], 'file').then(upload => {
                //     this.data.callFlag = false;
                //     console.log(upload)
                //     if (upload.statusCode == 200) {
                //         let data = JSON.parse(upload.data);
                //         this.setData({
                //             [`form[${index}].value`]: data
                //         });
                //     } else {
                //         wx.showToast({
                //             title: '上传失败',
                //             icon: 'none',
                //         })
                //     }
                // })
            }
        })
    },
    bindRegionChange(e) {
        let { index } = e.currentTarget.dataset, { label } = e.detail.selectedArray[1];
        this.setData({
            [`form[${index}].value`]: label
        })
    },
    focusIt(e) {
        let { index } = e.currentTarget.dataset;
        this.setData({
            [`form[${index}].focus`]: true
        })
    },
    syncInput(e) {
        let { index } = e.currentTarget.dataset;
        this.setData({
            [`form[${index}].value`]: e.detail.value
        })
    },
    submit() {
        let { form, callFlag } = this.data,
            params = {},
            title;
        if (callFlag) return
        for (let k = 0; k < form.length; k++) {
            if (!form[k].value && form[k].require) {
                title = `${form[k].flag.match(/company_city/gi)?'请选择':'请输入'}${form[k].label}`
                break;
            };
            if (form[k].value) {
                params[form[k].flag] = form[k].value
            }
        };
        if (title) {
            wx.showToast({
                title,
                icon: 'none'
            })
            return
        };
        let forms = wx.getStorageSync('forms') || {};
        forms.company = params;
        wx.setStorageSync('forms', forms);
        wx.navigateBack()
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