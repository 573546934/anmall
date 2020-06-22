// pages/community/index.js
const app = getApp();
import $http from '../../utils/request.js';
import regeneratorRuntime from '../../regenerator/runtime.js';
import { $stopWuxRefresher } from '../../components/index';
Page({

    /**
     * 页面的初始数据
     */
    data: {
        swiperIndex: 0,
        live: [],
        banner: ['1','2'],
        share: [],
        partner: [],
        cooperation: [],
        host: app.globalData.host
    },

    /**
     * 生命周期函数--监听页面加载
     */
    async onLoad(options) {
        wx.showLoading({
            title: '加载中',
            mask: true
        })
        await this.getLives();
        await this.getBanner();
        await this.getShare();
        await this.getActivity();
        await this.getPartner();
        await this.getCooperation();
        wx.hideLoading()
    },
    async refreshData() {
        await this.getLives();
        await this.getBanner();
        await this.getShare();
        await this.getActivity();
        await this.getPartner();
        await this.getCooperation();
        $stopWuxRefresher(false, `#scroll`);
    },
    swiperChange(e) {
        let { current } = e.detail;
        this.setData({ swiperIndex: current })
    },
    // getLives() {
    //     return new Promise(resolve => {
    //         $http.get('liveIndex').then(res => {
    //             let live = res.data;
    //             this.setData({ live })
    //             wx.hideLoading();
    //             resolve(true)
    //         })
    //     })
    // },
    getLives() {
        return new Promise(resolve => {
            $http.get(`ad?title=线上直播`).then(res => {
                let live = res.data;
                this.setData({ live })
                wx.hideLoading();
                resolve(true)
            })
        })
    },
    getBanner() {
        return new Promise(resolve => {
            $http.get(`ad?title=云社区轮播`).then(res => {
                let { data } = res;
                this.setData({ banner: data })
                console.log(res)
                resolve(true)
            })
        })
    },
    getShare() {
        return new Promise(resolve => {
            $http.get(`ad?title=大咖分享`).then(res => {
                let { data } = res;
                this.setData({ share: data })
                console.log(res)
                resolve(true)
            })
        })
    },
    getActivity() {
        return new Promise(resolve => {
            $http.get(`ad?title=线下活动`).then(res => {
                let { data } = res;
                data.forEach((v, i) => {
                    if (v.content) {
                        console.log(v)
                        let article = null;
                        article = app.towxml.toJson(v.content, 'html')
                        article = app.towxml.initData(article, {
                            base: app.globalData.host,
                            app: this
                        })
                        v.article = article;
                    }
                })
                this.setData({ activity: data })
                resolve(true)
            })
        })
    },
    getPartner() {
        return new Promise(resolve => {
            $http.get(`ad?title=合伙人招募`).then(res => {
                let { data } = res;
                data.forEach((v, i) => {
                    if (v.content) {
                        console.log(v)
                        let article = null;
                        article = app.towxml.toJson(v.content, 'html')
                        article = app.towxml.initData(article, {
                            base: app.globalData.host,
                            app: this
                        })
                        v.article = article;
                    }
                })
                this.setData({ partner: data })
                resolve(true)
            })
        })
    },
    getCooperation() {
        return new Promise(resolve => {
            $http.get(`ad?title=商务合作`).then(res => {
                let { data } = res;
                this.setData({ cooperation: data })
                console.log(res)
                resolve(true)
            })
        })
    },
    navigateIt(e) {
        let { item } = e.currentTarget.dataset;
        if (item.link && item.description) {
            wx[item.description]({
                url: item.link
            })
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