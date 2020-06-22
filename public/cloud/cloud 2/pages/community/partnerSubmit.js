// pages/community/partnerSubmit.js
const app = getApp();
import $http from '../../utils/request.js';
Page({

    /**
     * 页面的初始数据
     */
    data: {
        form: [],
        submitFlag: false
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function(options) {
        console.log(options)
        let { type } = options;
        this.setData({ type })
        wx.setNavigationBarTitle({
            title: type == 'institution' ? '机构' : '个人'
        })
        this.initForm(type);
    },
    initForm(type) {
        let form = [{
                label: '联系电话',
                flag: 'phone',
                value: '',
                require: true
            },
            {
                label: '所属行业',
                flag: 'industry',
                value: '',
                require: true
            },
            {
                label: '电子邮箱',
                flag: 'email',
                value: '',
            },
            {
                label: '微信号码',
                flag: 'wechat',
                value: '',
            },
        ], temp;
        if (type == 'institution') {
            temp = [{
                    label: '公司名称',
                    flag: 'name',
                    value: '',
                    require: true
                },
                {
                    label: '联系人姓名',
                    flag: 'contact_person',
                    value: '',
                    require: true
                }
            ]
        } else {
            temp = [{
                label: '真实姓名',
                flag: 'name',
                value: '',
                require: true
            }]
        }
        form = [...temp, ...form];
        this.setData({ form })
    },
    syncInput(e) {
        let { index } = e.currentTarget.dataset;
        this.setData({
            [`form[${index}].value`]: e.detail.value
        })
    },
    submit() {
        let { form, type } = this.data,
            title,
            params = {};
        for (let k = 0; k < form.length; k++) {
            if (!!form[k].value) {
                params[form[k].flag] = form[k].value
            }
            if (form[k].require && !form[k].value) {
                title = `请输入${form[k].label}`;
                break;
            }
        }
        if (title) {
            wx.showToast({
                title,
                icon: 'none'
            })
            return
        }
        params['type'] = 'institution' ? '2' : '1';
        $http.post('partner', params).then(res => {
            wx.showToast({
                title: res.message,
                icon: 'none',
                success: res => {
                    this.setData({ submitFlag: true })
                }
            })
        });
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