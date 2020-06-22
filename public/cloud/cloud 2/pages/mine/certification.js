// pages/mine/certification.js
const app = getApp();
import $http from '../../utils/request.js';
import forms from './forms';
var timer = null;
Page({

    /**
     * 页面的初始数据
     */
    data: {
        form: null,
        isIPX: app.globalData.isIPX,
        callFlag: false,
        host: app.globalData.host
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function(options) {
        let { action, type } = options,
        title;
        if (action.match(/manager/)) {
            title = '经纪人'
        } else if (action.match(/propertyowner/)) {
            title = `产权方个人`
        } else if (action.match(/owner/)) {
            title = `资方个人`
        }
        wx.setNavigationBarTitle({ title: `${title}信息` })
        this.setData({
            action,
            type: type || null,
            form: JSON.parse(JSON.stringify(forms[action]))
        })
        console.log(forms[action])
    },
    focusFun(e) {
        let { form } = this.data, { index } = e.currentTarget.dataset;
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
    toggleFun(e) {
        let { index } = e.currentTarget.dataset;
        this.setData({
            [`form[${index}].value`]: !this.data.form[index].value
        })
    },
    tapGender(e) {
        console.log(e)
        let { id, index } = e.currentTarget.dataset;
        this.setData({
            [`form[${index}].value`]: Number(id)
        })
    },
    submit() {
        let title, { form, callFlag, type, action } = this.data,
            params = {};
        if (callFlag) return
        for (let k = 0; k < form.length; k++) {
            if (form[k].require && !form[k].value) {
                title = form[k].holder;
                break;
            };
            if (form[k].flag != 'status' && form[k].value) {
                if (form[k].flag == 'sex') {
                    params[form[k].flag] = form[k].value == 1 ? '男' : '女'
                } else if (form[k].flag.match(/avatar|card/gi)) {
                    params[form[k].flag] = form[k].value.id
                } else {
                    params[form[k].flag] = form[k].value;
                }
            }
        }
        if (type) {
            params.type = type
        }
        if (title) {
            wx.showToast({
                title,
                icon: 'none'
            })
            return
        }
        wx.showModal({
            content: '认证信息提交后不可修改，您是否确认提交？',
            success: res => {
                if (res.confirm) {
                    $http.post(`${action}`, params).then(res => {
                        console.log(res)
                        if (!res.error) {
                            wx.showToast({
                                title: res.message,
                                icon: 'none'
                            })
                            timer = setTimeout(() => {
                                wx.navigateBack({
                                    delta: action.match(/manager/) ? 2 : 3
                                })
                            }, 1500)
                        }
                    })
                }
            }
        })

    },
    uploadFun(e) {
        if (this.data.callFlag) return
        let { index } = e.currentTarget.dataset;
        wx.chooseImage({
            count: 1,
            sizeType: ['compressed'],
            success: res => {
                let { tempFilePaths } = res;
                this.data.callFlag = true
                app.upload('api/uploadImg', tempFilePaths[0], 'file').then(upload => {
                    this.data.callFlag = false
                    if (upload.statusCode == 200) {
                        let data = JSON.parse(upload.data);
                        this.setData({
                            [`form[${index}].value`]: data
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
    onUnload() {
        wx.removeStorageSync('ids');
        clearTimeout(timer)
    },
    /**
     * 用户点击右上角分享
     */
    onShareAppMessage: function() {

    }
})