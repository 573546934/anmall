import $http from "../../utils/request";

const app = getApp();
Page({

    /**
     * 页面的初始数据
     */
    data: {
        member: null,
        form: {
            name: {
                label: '姓名',
                value: '',
                type: 'text'
            },
            sex: {
                label: '性别',
                value: '',
                type: 'radio',
                radios: [
                    { value: 1, label: '男' },
                    { value: 0, label: '女' }
                ]
            },
            phone: {
                label: '电话',
                value: '',
                type: 'number'
            },
            city: {
                label: '常驻城市',
                value: '',
                type: 'gps'
            }
        }
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function(options) {
        this.initData();
    },
    initData() {
        $http.get('member').then(res => {
            let { form } = this.data,
                member = res.data;
            for (let k in form) {
                if (k.match(/sex/)) {
                    form[k].value = member[k] ? (member[k] == '男' ? 1 : 2) : null;
                } else {
                    form[k].value = member[k] || ''
                }
            }
            this.setData({ form, member })
        })
    },
    syncInput(e) {
        let { id } = e.currentTarget, { value } = e.detail;
        this.setData({
            [`form.${id}.value`]: value
        })
    },
    tapGender(e) {
        let { id } = e.currentTarget;
        this.setData({
            [`form.sex.value`]: Number(id)
        })
    },
    tapLocation() {
        app.needGetLocationAuth().then(res => {
            if (res) {
                app.getLocation().then(res => {
                    if (res) {
                        let { city } = res.ad_info;
                        this.setData({
                            [`form.city.value`]: city
                        })
                    } else {
                        wx.showToast({
                            title: '获取位置失败！',
                            icon: 'none'
                        })
                    }
                })
            }
        })
    },
    getUserInfo(e) {
        let { userInfo } = e.detail;
        console.log(userInfo)
        if (userInfo) {
            this.setData({
              [`member.avatar`]:userInfo.avatarUrl,
              [`member.nickname`]:userInfo.nickName,
            })
        } else {
            wx.showToast({
                title: '您已取消授权',
                icon: 'none'
            })
        };
    },
    updateProfile() {
        let { form, member } = this.data,
            title,
            params = {};
        for (let k in form) {
            if (k.match(/sex/)) {
                params[k] = form[k].value == 1 ? '男' : '女'
            } else {
                params[k] = form[k].value
            }
            if (!form[k].value) {
                title = `请填写${form[k].label}`;
                break
            }
        };
        if (title) {
            wx.showToast({
                title,
                icon: 'none'
            })
            return
        };
        if(member.avatar){
          params.avatar = member.avatar;
        };
        if(member.nickname){
          params.nickname = member.nickname;
        }
        wx.showLoading({
            title: '加载中'
        });
        $http.post('member', params).then(res => {
            wx.showToast({
                title: '修改成功',
                icon: 'none',
                complete: res => {
                    wx.navigateBack();
                }
            })
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