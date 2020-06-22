// pages/demand/form.js
const app = getApp();
import $http from '../../utils/request.js';
import regeneratorRuntime from '../../regenerator/runtime.js';
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
        isIPX: app.globalData.isIPX,
        id: null
    },

    /**
     * 生命周期函数--监听页面加载
     */
    async onLoad(options) {
        let { id } = options;
        // let title = flag.match(/rent/) ? '出租信息' : (flag.match(/tenant/) ? '求租信息' : (flag.match(/buy/) ? '买' : '卖'))
        // wx.setNavigationBarTitle({ title })
        this.setData({ id });
        await this.getCountryCity();
        await this.initData()
    },
    tapFormItem(e) {
        let { item, index } = e.currentTarget.dataset;
        if (item.type != 'action') {
            this.setData({
                [`form[${index}].focus`]: true
            })
        } else {
            // wx.showActionSheet({
            //     itemList: ['国家', '城市'],
            //     success: res => {
            //         console.log(res)
            //     }
            // })
            // wx.navigateTo({
            //   url:`./country?flag=${this.data.flag}`
            // })
        }
    },
    initData() {
        wx.showLoading({
            title: '加载中...'
        })
        return new Promise(resolve => {
            $http.get(`demand?id=${this.data.id}`).then(res => {
                wx.hideLoading();
                let { data } = res, { form, assets_type } = this.data;
                console.log(data)
                for (let k = 0; k < form.length; k++) {
                    for (let j in data) {
                        if (j == form[k].flag) {
                            form[k].value = data[j] || ''
                        }
                    }
                }
                if (assets_type.value) {
                    for (let k = 0; k < assets_type.value.length; k++) {
                        if (assets_type.value[k].name == data.assets_type) {
                            assets_type.value[k].select = true
                        }
                    }
                }
                let title = data.type.match(/rent/) ? '出租信息' : (data.type.match(/tenant/) ? '求租信息' : (data.type.match(/buy/) ? '买' : '卖'))
                wx.setNavigationBarTitle({ title })
                this.setData({ form, other: data.other || '', assets_type, type: data.type })
            })
        })
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
            { form, other, assets_type, type, id } = this.data,
            params = {};
        params.type = type;
        params.id = id;
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
                icon: 'none'
            });
            return
        }
        console.log(params)
        // return
        wx.showLoading({ title: '加载中...' })
        $http.post('updemand', params).then(res => {
            if (res.message) {
                wx.showToast({
                    title: res.message,
                    icon: 'none',
                    complete: res => {
                        wx.navigateBack()
                    }
                })

            }
        })
    },
    getCountryCity() {
        return new Promise(resolve => {
            $http.get('categorys').then(res => {
                this.setData({
                    city: res.data.sx.city,
                    assets_type: res.data.sx.assets_type,
                })
                resolve(true)
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
    updatePrePage() {
        let pages = getCurrentPages();
        if (pages.length > 1) {
            let prePage = pages[pages.length - 2];
            if (prePage.initData) {
                prePage.initData();
            };
        }
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
        this.updatePrePage()
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