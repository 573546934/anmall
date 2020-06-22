//app.js
const map = require('./utils/qqmap-wx-jssdk.min.js');
const Towxml = require('/towxml/main');
App({
    onLaunch(options) {
        this.initData(options)
        this.judgeIphoneX()
    },
    initData(options) {
        let { guide_id, friend_id, scene } = options.query;
        if (scene) {
            let scene_params = decodeURIComponent(scene).split('&');
            scene_params.forEach((v, i) => {
                if (v.match(/^friend_id/gi)) {
                    friend_id = v.split('=')[1]
                } else if (v.match(/^guide_id/gi)) {
                    guide_id = v.split('=')[1]
                }
            })
        }
        this.globalData.guideId = guide_id || 0;
        this.globalData.friendId = friend_id || 0;
    },
    judgeIphoneX() {
        let { model } = wx.getSystemInfoSync();
        this.globalData.isIPX = !!(model.search("iPhone X") !== -1 || model.search("iPhone 11") !== -1 || /^unknown<iPhone/.test(model))
    },
    needGetLocationAuth() {
        return new Promise(resolve => {
            wx.getSetting({
                success: setting => {
                    wx.authorize({
                        scope: 'scope.userLocation',
                        success: auth => {
                            resolve(true);
                        },
                        fail: auth => {
                            this.getLocationAuthByManual().then(res => {
                                resolve(res)
                            })
                        }
                    })
                }
            })
        })
    },
    getLocationAuthByManual() {
        return new Promise(resolve => {
            wx.showModal({
                title: '位置授权',
                content: '需要您的位置信息',
                showCancel: false,
                success: modal => {
                    if (modal.confirm) {
                        this.openLocationSetting().then(res => {
                            resolve(res)
                        });
                    }
                }
            })
        })
    },
    openLocationSetting() {
        return new Promise(resolve => {
            wx.openSetting({
                complete: open_setting => {
                    resolve(!!open_setting.authSetting['scope.userLocation'])
                }
            })
        })
    },
    getLocation(no_loading) {
        no_loading ? '' : wx.showLoading({
            title: '正在加载位置信息...',
        });
        return new Promise((resolve) => {
            wx.getLocation({
                type: 'gcj02',
                altitude: false,
                complete: location => {
                    if (location.latitude && location.longitude) {
                        let qqmapsdk = new map({
                            key: this.globalData.appMap
                        });
                        qqmapsdk.reverseGeocoder({
                            location: location,
                            // location: '100.04122,98.81437',
                            complete: complete => {
                                if (complete.result) {
                                    // console.log(complete.result)
                                    // let params = {
                                    //     location: {
                                    //         latitude: complete.result.location.lat,
                                    //         longitude: complete.result.location.lng
                                    //     },
                                    //     country: complete.result.address_component.nation,
                                    //     address: complete.result.address
                                    // };
                                    // this.globalData.locationObject = params;
                                    resolve(complete.result)
                                } else {
                                    resolve(false)
                                };
                            }
                        })
                    } else {
                        resolve(false)
                    }!no_loading ? wx.hideLoading() : ''
                }
            })
        })
    },
    upload(url, filePath, name = 'image', k, formData) {
        return new Promise(resolve => {
            wx.uploadFile({
                url: `${this.globalData.host}/${url}`,
                filePath,
                name,
                formData,
                header: {
                    "api-token": this.globalData.apiToken,
                    "Member-Token": this.globalData.memberToken,
                    "Content-Type": "application/json"
                },
                success: res => {
                    res.flag = k;
                    resolve(res)
                }
            })
        })
    },
    globalData: {
        isIPX: false,
        member: null,
        // host: 'https://zhaogu.xwebsite.net',
        host: 'https://zhaogu.arnny.net',
        appMap: '6OXBZ-UOF3O-K65WZ-SJ35T-BIXT5-X3F6R',
        guideId: 0,
        friendId: 0,
        projectId: null,
        apiToken: 'c307d593b1a7774861b649c12ebdd4ec',
        memberToken: null
    },
    towxml: new Towxml()
})