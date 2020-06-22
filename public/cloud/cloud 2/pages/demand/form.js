// pages/demand/form.js
const app = getApp();
import $http from '../../utils/request.js';
var timer;
Page({

    /**
     * 页面的初始数据
     */
    data: {
        form: [
            { label: '姓名', value: '', flag: 'telname', require: true, type: 'text' },
            { label: '联系方式', value: '', flag: 'phone', require: true, type: 'number' },
            { label: '城市', value: '', flag: 'city', type: 'action' },
            { label: '预算', value: '', flag: 'price', type: 'digit' },
            { label: '面积', value: '', flag: 'area', type: 'digit' },
        ],
        types: [
            { label: '全部', value: '全部' },
            { label: '写字楼', value: '写字楼' },
            { label: '商业', value: '商业' },
            { label: '酒店', value: '酒店' },
            { label: '工业用地', value: '工业用地' },

        ],
        assets_type: null,
        other: null,
        isIPX: app.globalData.isIPX
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function(options) {
        let { flag } = options;
        let title = flag.match(/rent/) ? '出租信息' : (flag.match(/tenant/) ? '求租信息' : (flag.match(/buy/) ? '买' : '卖'))
        wx.setNavigationBarTitle({ title })
        this.setData({ flag });
        this.getCountryCity();
    },
    tapFormItem(e) {
        let { item, index } = e.currentTarget.dataset;
        if (item.type != 'action') {
            this.setData({
                [`form[${index}].focus`]: true
            })
        }
    },
    syncInput(e) {
        let { index } = e.currentTarget.dataset;
        index != undefined ? this.setData({
                [`form[${index}].value`]: e.detail.value
            }) :
            this.setData({
                other: e.detail.value
            })
    },
    submit(e) {
        let title = '',
            { form, other, assets_type, flag } = this.data,
            params = {};
        params.type = flag
        for (let k = 0; k < form.length; k++) {
            if (form[k].require && !form[k].value) {
                title = `请输入${form[k].label}`;
                break;
            };
            if (!!form[k].value) {
                params[form[k].flag] = form[k].value
            }
        }
        if (other) {
            params['other'] = other
        }
        if (assets_type.value.length) {
            for (let k = 0; k < assets_type.value.length; k++) {
                if (assets_type.value[k].select) {
                    params['assets_type'] = assets_type.value[k].name;
                    break;
                }
            }
        }
        if (title) {
            wx.showToast({
                title,
                icon: 'none',
                duration: 2000
            });
            return
        }
        wx.showLoading({ title: '加载中...' })
        $http.post('demand', params).then(res => {
            wx.hideLoading();
            if (!res.error && res.message) {
                wx.showModal({
                    content: res.message,
                    confirmText: '查看需求',
                    cancelText: '关闭',
                    success: modal => {
                        if (modal.confirm) {
                            wx.redirectTo({
                                url:'/pages/demand/list'
                            })
                        } else if (modal.cancel) {
                            wx.navigateBack({
                                delta: 3
                            })
                        }
                    }
                })
            }
        })
    },
    getCountryCity() {
        $http.get('categorys').then(res => {
            console.log(res)
            this.setData({
                city: res.data.sx.city,
                assets_type: res.data.sx.assets_type,
            })
        })
    },
    selectAssetsType(e) {
        let { index } = e.currentTarget.dataset, { value } = this.data.assets_type;
        for (let k = 0; k < value.length; k++) {
            if (k == index) {
                value[k].select = !value[k].select
            } else {
                value[k].select = false;
            }
        }
        this.setData({
            [`assets_type.value`]: value
        })
    },
    selectCity(e) {
        let index = e.detail.value,
            form_index = e.currentTarget.dataset.index,
            { value } = this.data.city;
        this.setData({
            [`form[${form_index}].value`]: value[index].name
        })
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
        clearTimeout(timer)
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