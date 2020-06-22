// pages/mine/index.js
const app = getApp();
import $http from '../../utils/request';
Page({
    /**
     * 页面的初始数据
     */
    data: {
        rights: [
            { label: '专属客服', icon: '/images/icons/service.png', nav: './service' },
            { label: '我的名片', icon: '/images/icons/name-card.png', nav: './nameCard' },
            { label: '晋升攻略', icon: '/images/icons/svip.png', nav: './svip' },
        ],
        // myProject:[
        //   {label:'我的收藏',icon:'/images/icons/collection.png'},
        //   {label:'已报备',icon:'/images/icons/report.png'},
        //   {label:'已完成',icon:'/images/icons/completed.png'},
        // ],
        myProjects: [
            { label: '提交项目', icon: '/images/icons/icon_tijiao@2x.png', nav: `./publish` },
            { label: '我关注的', icon: '/images/icons/icon_wgzd@2x.png', nav: `./project?type=myAllArticles&title=我关注的项目` },
            { label: '已完成的', icon: '/images/icons/icon_yiwancheng@2x.png', nav: `./project?type=myArticles&title=已成交的项目` },
        ],
        extraServices: [
            { label: '认证中心', icon: '/images/icons/certification.png', nav: './action', flag:1 },
            { label: '认证中心', icon: '/images/icons/certification.png', nav: './action', flag:2 },
            { label: '我的客户', icon:'/images/icons/icon_kehu@2x.png', nav: './client', flag:3 },
            { label: '我的需求', icon: '/images/icons/icon_xuqiu@2x.png', nav: '/pages/demand/list', auth:true},
            // { label: '我关注的项目', nav: './project?type=myAllArticles&title=我关注的项目' },
            // { label: '已成交的项目', nav: './project?type=myArticles&title=已成交的项目' },
            // { label: '提交成交项目', nav: './publish' },
            // { label: '发布需求', nav: '/pages/demand/push' },
            { label: '意见反馈', icon:'/images/icons/icon_fankui@2x.png', nav: './feedback' },
        ],
        member: {},
        isIPX:app.globalData.isIPX
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad(options) {
        wx.showLoading({
            title: '加载中',
            mask: true
        });
    },
    initData() {
        $http.get('member').then(res => {
            let member = res.data || {};
            this.setData({ member }, () => {
                wx.hideLoading()
            })
        })
    },
    needAuth(){
        let { avatar, nickname } = this.data;
        if(!avatar || !nickname){
            wx.showModal({

            })
        }
    },
    getUserInfo(e) {
        let { userInfo } = e.detail;
        if (userInfo) {
            this.updateUserInfo(userInfo)
        } else {
            wx.showToast({
                title: '您已取消授权',
                icon: 'none'
            })
        };
    },
    updateUserInfo(userInfo) {
        let { nickName, avatarUrl } = userInfo, { member } = this.data;
        wx.showLoading({ title: '加载中', mask: true })
        $http.post('member', { nickname: nickName, avatar: avatarUrl }).then(res => {
            wx.hideLoading();
            if (res.data) {
                member.nickname = nickName;
                member.avatar = avatarUrl;
                this.setData({ member })
            }
        })
    },
    naigateIt(e) {
        let { url,auth } = e.currentTarget.dataset, {type} = this.data.member;
        if(auth && (!type || type == 1)){
            wx.showModal({
                content:'请完善您的资料',
                cancelText:'暂不完善',
                confirmText:'完善资料',
                success:res=>{
                    if(res.confirm){
                        wx.navigateTo({
                            url:'./profile'
                        })
                    }
                }
            })
            return
        }
        wx.navigateTo({
            url
        })
    },
    actions(e) {
        let { actions, types } = e.currentTarget.dataset;
        wx.showActionSheet({
            itemList: actions.map(v => v.label),
            success: action => {
                let { tapIndex } = action;
                if (actions[tapIndex].label.match(/资方|产权方/)) {
                    wx.showActionSheet({
                        itemList: types.map(v => v.label),
                        success: type => {
                            actions[tapIndex].select = true;
                            types[type.tapIndex].select = true;
                            this.setNavLink(actions, types);
                        }
                    })
                } else {
                    actions[tapIndex].select = true;
                    this.setNavLink(actions, [])
                };
            }
        })
    },
    setNavLink(actions, types) {
        let url = '';
        for (let k = 0; k < actions.length; k++) {
            if (actions[k].select) {
                url += `?action=${actions[k].value}`;
                break;
            }
        }
        for (let k = 0; k < types.length; k++) {
            if (types[k].select) {
                url += `&type=${types[k].value}`;
                break;
            }
        };
        if (url) {
            wx.navigateTo({
                url: `./certification${url}`
            })
        }
        console.log(url)
    },
    /**
     * 生命周期函数--监听页面初次渲染完成
     */
    /**
     * 生命周期函数--监听页面显示
     */
    onShow: function() {
        this.initData();
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