// pages/mine/nameCard.js
const app = getApp();
import regeneratorRuntime from '../../regenerator/runtime.js';
import $http from '../../utils/request.js';
import util from '../../utils/util.js';
const telIcon = '../../images/icons/tel-icon.png'
const qrcode = '../../images/qrcode.png';
const banner = '../../images/auth-bg.png';
Page({

    /**
     * 页面的初始数据
     */
    data: {
        forwards: [
            { icon: '../../images/icons/wechat.png', label: '微信' },
            { icon: '../../images/icons/moment.png', label: '朋友圈' },
            { icon: '../../images/icons/qq.png', label: 'QQ' },
            { icon: '../../images/icons/tiktok.png', label: '抖音' },
            { icon: '../../images/icons/download.png', label: '保存到手机' },
        ],
        current: 0
    },
    /**
     * 生命周期函数--监听页面加载
     */
    async onLoad(options) {
        wx.showLoading({
            title: "名片生成中...",
            mask: true
        })
        await this.getPosterData();
        this.preDraw();
    },
    getPosterData() {
        return new Promise(resolve => {
            $http.get('getQrCode').then(res => {
                for (let k in res.data) {
                    this.setData({
                        [k]: res.data[k]
                    })
                };
                resolve(true)
            })
        })
    },
    rpxToPx(rpx) {
        let { screenWidth } = wx.getSystemInfoSync();
        return (rpx / 750) * screenWidth;
    },
    destroyQrcode() {
        $http.post('qrcode', { qrcode: this.data.qrcode }).then(res => {
            console.log(res)
        })
    },
    downloadFile(url) {
        return new Promise(resolve => {
            wx.downloadFile({
                url,
                success: res => {
                    resolve(res)
                }
            });
        })
    },
    swiperChange(e) {
        this.setData({
            current: e.detail.current
        })
    },
    keepPoster() {
        let { items, current } = this.data;
        if (items[current]) {
            wx.saveImageToPhotosAlbum({
                filePath: items[current],
                success: () => {
                    wx.showToast({
                        title: '保存成功！'
                    })
                },
                fail: () => {
                    wx.showToast({
                        title: '保存失败！',
                        icon: 'none'
                    })
                }
            });
        }

    },
    preDraw() {
        let temp = [],
            imgs = [],
            { bgimg, qrcode, name, phone } = this.data;
        qrcode ? temp.push(`${app.globalData.host}${qrcode}`) : null;
        (bgimg || []).forEach(v => {
            if (v.img) {
                temp.push(`${app.globalData.host}${v.img.url}`)
            }
        })
        for (let k = 0; k < temp.length; k++) {
            imgs[k] = this.downloadFile(temp[k])
        };
        Promise.all(imgs).then(items => {
            items = items.filter(v => v.statusCode == 200).map(v => v.tempFilePath);
            if (items.length == imgs.length) {
                if (items.length && qrcode) {
                    let is_qrcode = items[0],
                        new_items = items.slice(1),
                        new_temp = [];
                    for (let i = 0; i < new_items.length; i++) {
                        let params = { i, is_qrcode, name, phone, banner: new_items[i] }
                        new_temp[i] = this.canvasPoster(params)
                    }
                    Promise.all(new_temp).then(res => {
                        this.setData({ items: res.filter(v => !!v), poster: true })
                        wx.hideLoading()
                        console.log(res)
                    })

                }
            } else {
                wx.showToast({
                    title: "项目海报生成失败",
                    icon: "none"
                })
            }
            this.setData({ items })
        })
    },
    canvasPoster(params) {
        console.log(params)
        return new Promise(resolve => {
            const ctx = wx.createCanvasContext(`canvas${params.i}`);
            // wx.createSelectorQuery().select(`#canvas${params.i}`).boundingClientRect(rect => {
            // let { width, height } = rect;
            ctx.rect(0, 0, this.rpxToPx(600), this.rpxToPx(900));
            ctx.setFillStyle('#ffffff');
            ctx.fill();
            ctx.drawImage(params.banner, 0, 0, this.rpxToPx(600), this.rpxToPx(640));
            ctx.save();
            ctx.beginPath();
            ctx.drawImage(params.is_qrcode, this.rpxToPx(70), this.rpxToPx(690), this.rpxToPx(110), this.rpxToPx(110));
            if (params.phone) {
                ctx.drawImage(telIcon, this.rpxToPx(340), this.rpxToPx(712), this.rpxToPx(20), this.rpxToPx(20));
            }
            ctx.restore();
            ctx.setFontSize(this.rpxToPx(24));
            ctx.fillStyle = "#333333";
            ctx.fillText(params.name || '匿名用户', this.rpxToPx(222), this.rpxToPx(730));
            if (params.phone) {
                ctx.fillText(params.phone, this.rpxToPx(370), this.rpxToPx(730));
            }
            ctx.fillText('邀请您加入兆古云', this.rpxToPx(222), this.rpxToPx(775));
            ctx.restore();
            ctx.setFontSize(this.rpxToPx(20));
            ctx.setTextAlign("center");
            ctx.fillStyle = "#CBCBCB";
            ctx.fillText('长按识别或扫描二维码进入', this.rpxToPx(300), this.rpxToPx(860));
            ctx.moveTo(this.rpxToPx(110), this.rpxToPx(853));
            ctx.lineTo(this.rpxToPx(163), this.rpxToPx(853));
            ctx.lineWidth = this.rpxToPx(2);
            ctx.strokeStyle = "#CBCBCB";
            ctx.stroke();
            ctx.moveTo(this.rpxToPx(445), this.rpxToPx(853));
            ctx.lineTo(this.rpxToPx(498), this.rpxToPx(853));
            ctx.lineWidth = this.rpxToPx(2);
            ctx.strokeStyle = "#CBCBCB";
            ctx.stroke();
            ctx.draw(true, () => {
                setTimeout(() => {
                    wx.canvasToTempFilePath({
                        canvasId: `canvas${params.i}`,
                        success: res => {
                            // this.destroyQrcode();
                            let { tempFilePath } = res;
                            if (tempFilePath !== "") {
                                resolve(tempFilePath)
                                // this.setData({
                                //     showPoster: true,
                                //     poster: tempFilePath
                                // });
                            } else {
                                resolve(false)
                            }
                            // wx.hideLoading();
                        },
                        fail: () => {
                            resolve(false)
                            // wx.showToast({
                            //     title: "项目海报生成失败",
                            //     icon: "none"
                            // })
                        }
                    });
                }, 100);
            })
            // }).exec()
        })

        // if (this.data.poster) return
        // wx.showLoading({
        //     title: "名片生成中...",
        //     mask: true
        // })
        // let { avatar, qrcode, bgimg, name, phone } = this.data,
        //     temp = [];
        // let imgs = [bgimg.img.url, qrcode, avatar]
        // for (let k = 0; k < imgs.length; k++) {
        //     temp[k] = this.downloadFile(`${app.globalData.host}${imgs[k]}`)
        // }
        // Promise.all(temp).then(items => {
        //     if (items.filter(v => v.statusCode == 200).length == items.length) {
        //         let imgs = items.map(v => v.tempFilePath);
        //         const ctx = wx.createCanvasContext("canvas");
        //         wx.createSelectorQuery().select('#canvas').boundingClientRect(rect => {
        //             let { width, height } = rect;
        //             ctx.rect(0, 0, width, height);
        //             ctx.setFillStyle('#ffffff');
        //             ctx.fill();
        //             ctx.drawImage(imgs[0], 0, 0, width, this.rpxToPx(685));
        //             ctx.drawImage(imgs[1], this.rpxToPx(435), this.rpxToPx(730), this.rpxToPx(155), this.rpxToPx(155));
        //             ctx.save();
        //             ctx.beginPath();
        //             ctx.setStrokeStyle('transparent');
        //             ctx.setLineWidth(this.rpxToPx(1));
        //             ctx.shadowOffsetX = this.rpxToPx(0);
        //             ctx.shadowOffsetY = this.rpxToPx(4);
        //             ctx.shadowBlur = this.rpxToPx(16);
        //             ctx.shadowColor = 'rgba(235,235,235,1)';
        //             ctx.arc(this.rpxToPx(110), this.rpxToPx(685), this.rpxToPx(60), 0, Math.PI * 2);
        //             ctx.stroke();
        //             ctx.clip();
        //             ctx.drawImage(imgs[2], this.rpxToPx(50), this.rpxToPx(625), this.rpxToPx(120), this.rpxToPx(120));
        //             ctx.restore();
        //             if (phone) {
        //                 ctx.drawImage(telIcon, this.rpxToPx(200), this.rpxToPx(782), this.rpxToPx(24), this.rpxToPx(30));
        //             }
        //             ctx.setFontSize(this.rpxToPx(32));
        //             ctx.fillStyle = "#333333";
        //             ctx.fillText(name || '匿名用户', this.rpxToPx(50), this.rpxToPx(810));
        //             if (phone) {
        //                 ctx.setFontSize(this.rpxToPx(28));
        //                 ctx.fillStyle = "#333333";
        //                 ctx.fillText(phone, this.rpxToPx(235), this.rpxToPx(808));
        //             }
        //             ctx.setFontSize(this.rpxToPx(25));
        //             ctx.fillStyle = "#04A7A9";
        //             ctx.fillText('长按识别二维码', this.rpxToPx(50), this.rpxToPx(850));
        //             ctx.setFontSize(this.rpxToPx(21));
        //             ctx.fillStyle = "#333333";
        //             ctx.fillText('获取该项目更多信息', this.rpxToPx(50), this.rpxToPx(885));
        //             ctx.draw(true, () => {
        //                 setTimeout(() => {
        //                     wx.canvasToTempFilePath({
        //                         canvasId: "canvas",
        //                         success: res => {
        //                             let tempFilePath = res.tempFilePath;
        //                             if (tempFilePath !== "") {
        //                                 this.setData({
        //                                     poster: tempFilePath
        //                                 });
        //                             }
        //                             wx.hideLoading()
        //                             this.destroyQrcode();
        //                         },
        //                         fail: () => {
        //                             wx.showToast({
        //                                 title: "名片生成失败",
        //                                 icon: "none"
        //                             })
        //                         }
        //                     });
        //                 }, 100);
        //             })
        //         }).exec()
        //     } else {
        //         wx.showToast({
        //             title: "名片生成失败",
        //             icon: "none"
        //         })
        //     }
        // })
    },
    onShareAppMessage() {
        let share = util.shareMiniProgram();
        share['title'] = this.data.data.title;
        share['imageUrl'] = this.data.poster;
        return share;
    }
})