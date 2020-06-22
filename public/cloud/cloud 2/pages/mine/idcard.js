// pages/mine/idcard.js
import regeneratorRuntime from '../../regenerator/runtime.js';
import $http from '../../utils/request';
const app = getApp();
var timer = null;
Page({

    /**
     * 页面的初始数据
     */
    data: {
        top: null,
        bttm: null
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function(options) {
        let { index } = options;
        this.setData({ index })
        let ids = wx.getStorageSync('ids') || [];
        ids.length ? this.setData({
            top: app.globalData.host + ids[0].url,
            bttm: app.globalData.host + ids[1].url,
        }) : null
    },
    initData() {
        return new Promise(resolve => {
            $http.get('member').then(res => {
                resolve(true)
            })
        })
    },
    selectImg(e) {
        let { flag } = e.currentTarget.dataset;
        console.log(flag)
        wx.chooseImage({
            count: 1,
            sizeType: ['compressed'],
            success: res => {
                let { tempFilePaths } = res;
                this.setData({
                    [`${flag}`]: tempFilePaths[0]
                })
            }
        })
    },
    async submit() {
        let { top, bttm } = this.data;
        if (!top || !bttm) {
            wx.showToast({
                title: '请上传身份证信息',
                icon: 'none',
            })
            return
        }
        let imgs = [top, bttm],
            temp = [];
        await this.initData();
        for (let k = 0; k < imgs.length; k++) {
            temp[k] = app.upload('api/uploadImg', imgs[k], 'file');
        }
        wx.showLoading({ title: '上传中...' })
        Promise.all(temp).then(items => {
            console.log(items)
            wx.hideLoading()
            if (items.length == items.filter(v => v.statusCode == 200).length) {
                wx.showToast({
                    title: '上传成功',
                    icon: 'none'
                })
                timer = setTimeout(() => {
                    wx.setStorageSync('ids', items.map(v => JSON.parse(v.data)))
                    wx.navigateBack();
                }, 1500)
            } else {
                wx.showToast({
                    title: '上传失败',
                    icon: 'none',
                })
            }
        })
    },
    updatePrePage() {
        let pages = getCurrentPages(),
            { index } = this.data;
        if (pages.length > 1) {
            let prePage = pages[pages.length - 2];
            let ids = wx.getStorageSync('ids') || null;
            if (ids) {
                prePage.setData({
                    [`form[${index}].value`]: ids.map(v => v.id)
                })
            }

        }
    },
    onUnload() {
        this.updatePrePage();
        clearTimeout(timer)
    }
})