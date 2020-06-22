// pages/mine/publish.js
const app = getApp();
import $http from '../../utils/request';
const form = [
    { label: '选择已报备的项目', flag: 'id', value: '', holder: '请选择选择已报备的项目', require: true },
    { label: '成交价格', flag: 'deal_price', value: '', holder: '请输入成交价格' },
    { label: '签约日期', flag: 'deal_date', value: '', holder: '请选择签约日期' },
    { label: '交易方式', flag: 'deal_type', value: '', holder: '请选择交易方式' },
]
Page({

    /**
     * 页面的初始数据
     */
    data: {
        form: [],
        projects: [],
        host: app.globalData.host,
        isIPX: app.globalData.isIPX,
        disabled: false
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function(options) {
        this.setData({
            form: JSON.parse(JSON.stringify(form))
        })
        this.getUndoneArticle();
    },
    getUndoneArticle() {
        // wx.showLoading({ title: '加载中...' })
        $http.get('undoneArticle').then(res => {
            wx.hideLoading();
            let { data } = res;
            this.setData({ projects: data })
            console.log(res)
        })
    },
    pickChange(e) {
        let { index } = e.currentTarget.dataset;
        this.setData({
            [`form[${index}].value`]: String(e.detail.value)
        })
        console.log(index)
        console.log(e)
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
    submit(e) {
        let { form, projects } = this.data, params = {}, title;
        console.log(form)
        for (let k = 0; k < form.length; k++) {
            if (form[k].require && !form[k].value) {
                title = form[k].holder;
                break
            };
            if (form[k].value) {
                if (form[k].flag == 'id') {
                    params[form[k].flag] = projects[form[k].value].id
                } else {
                    params[form[k].flag] = form[k].value
                }
            }

        };
        if (title) {
            wx.showToast({
                title,
                icon: 'none'
            })
            return
        }
        wx.showLoading({ title: '加载中...' })
        $http.post('completeArticle', params).then(res => {
            if (!res.error) {
                wx.showToast({
                    title: res.message,
                    icon: "none",
                    duration: 1500
                })
                this.onLoad()
            }
        })
    }
})