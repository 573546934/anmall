// pages/index/index.js
const app = getApp();
import $http from '../../utils/request';
import util from '../../utils/util.js';
import regeneratorRuntime from '../../regenerator/runtime.js';
import { $stopWuxRefresher } from '../../components/index';
Page({

    /**
     * 页面的初始数据
     */
    data: {
        swiperIndex: 0,
        nowCurrent: 0, //当前选中滑块
        nowCurrent1: 0, //当前选中滑块
        nowCurrent2: 0, //当前选中滑块
        host: app.globalData.host,
        city: null

    },

    /**
     * 生命周期函数--监听页面加载
     */
    async onLoad(options) {
        wx.showLoading({
            title: '加载中',
            mask: true
        });
        this.setLocation();
        await this.initData();
        await this.getBrands();
        await this.getLives();
        await this.getRequire()
        wx.hideLoading();
    },
    initData() {
        return new Promise(resolve => {
            $http.get('home').then(res => {
                for (let k in res.data) {
                    this.setData({
                        [k]: res.data[k]
                    })
                }
                resolve(true)
            })
        })
    },
    getLives() {
        return new Promise(resolve => {
            $http.get(`ad?title=线上直播`).then(res => {
                let live = res.data;
                this.setData({ live })
                console.log(live)
                resolve(true)
            })
        })
    },
    getRequire() {
        return new Promise(resolve => {
            $http.get(`ad?title=资产需求`).then(res => {
                let requires = res.data;
                this.setData({ requires })
                // console.log(live)
                resolve(true)
            })
        })
    },
    getBrands(){
        return new Promise(resolve=>{
            $http.get('brands').then(res=>{
                let { data } = res.data;
                this.setData({brands:data})
                console.log(this.data.brands)
                resolve(true)
            })
        })
    },
    async refreshData() {
        await this.initData();
        await this.getBrands()
        await this.getRequire()
        $stopWuxRefresher(false, `#scroll`);
    },
    setLocation() {
        app.needGetLocationAuth().then(res => {
            if (res) {
                app.getLocation(true).then(res => {
                    if (res) {
                        let { city } = res.ad_info;
                        this.setData({ city })
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
    toCert() {
        wx.navigateTo({
            url: '/pages/mine/action'
        })
    },
    toProjectList(e) {
        let { id } = e.currentTarget.dataset;
        console.log(id)
        if (id == 5 || id == 6) {
            wx.navigateTo({
                url: `/pages/project/${id == 5?'overseas':'bulk'}`
            })
        } else {
            app.globalData.projectId = id;
            wx.switchTab({
                url: `/pages/project/list`
            })
        }
    },
    bannerNavigate(e) {
        let { item } = e.currentTarget.dataset;
        if (item.description && item.link) {
            wx[`${item.description}`]({
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
    //选中滑块，滑块放大
    swiperChange(e) {
        let { id } = e.currentTarget;
        this.setData({
            [id]: e.detail.current
        })
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
        return util.shareMiniProgram();
    }
})