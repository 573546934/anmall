// pages/project/detail.js
const app = getApp();
import regeneratorRuntime from '../../regenerator/runtime.js';
import $http from '../../utils/request.js';
import util from '../../utils/util.js';
const telIcon = '../../images/icons/tel-icon.png';
const rectIcon = '../../images/icons/rect@2x.png'
Page({

    /**
     * 页面的初始数据
     */
    data: {
        id: null,
        host: app.globalData.host,
        data: null,
        bannerIndex: 0,
        article: null,
        isIPX: app.globalData.isIPX,
        showPoster: false,
        friend_id:null,
        forwards: [
            { icon: '../../images/icons/wechat.png', label: '微信' },
            { icon: '../../images/icons/moment.png', label: '朋友圈' },
            { icon: '../../images/icons/qq.png', label: 'QQ' },
            { icon: '../../images/icons/tiktok.png', label: '抖音' },
            { icon: '../../images/icons/download.png', label: '保存到手机' },
        ],
        tabs:['资料','信息','介绍','亮点','设施','项目'],
        currentTab:0,
        toView:'',
        showTabs:false,
        tabsTop:[]
    },
  onTab: function (e) {
    let { index } = e.currentTarget.dataset
    // if (this.data.currentTab == index) {
    //   return;
    // }
    this.setData({
      currentTab: index,
      toView:'view'+index
    })
  },
  toScroll:function(e){
    if (e.detail.scrollTop >= this.data.tabsTop[0]){
      this.setData({
        showTabs:true
      })
    }else{
      this.setData({
        showTabs: false
      })
    }
    // console.log(e)
    if (e.detail.scrollTop <this.data.tabsTop[1] ){
      this.setData({
        currentTab: 0,
      })
    } else if (e.detail.scrollTop >= this.data.tabsTop[1] && e.detail.scrollTop < this.data.tabsTop[2]){
      this.setData({
        currentTab: 1,
      })
    } else if (e.detail.scrollTop >= this.data.tabsTop[2] && e.detail.scrollTop < this.data.tabsTop[3]){
      this.setData({
        currentTab: 2,
      })
    } else if (e.detail.scrollTop >= this.data.tabsTop[3] && e.detail.scrollTop < this.data.tabsTop[4]) {
      this.setData({
        currentTab: 3,
      })
    } else if (e.detail.scrollTop >= this.data.tabsTop[4] && e.detail.scrollTop < this.data.tabsTop[5]) {
      this.setData({
        currentTab: 4,
      })
    } else if (e.detail.scrollTop >= this.data.tabsTop[5]) {
      this.setData({
        currentTab: 5,
      })
    }
  },
  _getNavToTop: function () {
    let that = this
    let tabsTop = []
    this.data.tabs.forEach((item,index)=>{
      let str = `#view${index}`
      console.log('str',str)
      let query = wx.createSelectorQuery();
      query.select(str).boundingClientRect((rect) => {
        if (rect && rect.top){
          tabsTop.push(rect.top)
        }else{
          tabsTop.push('')
        }
      }).exec()
    })
    that.setData({ tabsTop: tabsTop })
    console.log('tabsTop', this.data.tabsTop)
  },

    /**
     * 生命周期函数--监听页面加载
     */
    async onLoad(options) {
      
        let { id, scene } = options;
        if (scene) {
            let scene_params = decodeURIComponent(scene).split('&');
            for (let k = 0; k < scene_params.length; k++) {
                if (scene_params[k].match(/^id|friend_id/gi)) {
                    this.setData({ [`${scene_params[k].split('=')[0]}`]: scene_params[k].split('=')[1] });
                }
            }
        } else {
            this.setData({ id });
        }
        await this.initData();
        await this.getPosterData();
        // await this.canvasPoster();

      await this._getNavToTop()
    },
    initData() {
        return new Promise(resolve => {
            let url = `article?id=${this.data.id}`;
            if(this.data.friend_id){
                url += `&friend_id=${this.data.friend_id}`
            }
            console.log(url)
            $http.get(url).then(res => {
                let { data } = res, article = null;
                data.type = 'init'
                if (data.content) {
                    wx.setNavigationBarTitle({ title: data.title })
                    article = app.towxml.toJson(
                        data.content, // `markdown`或`html`文本内容
                        'html' // `markdown`或`html`
                    );
                    article = app.towxml.initData(article, {
                        base: app.globalData.host,
                        app: this
                    })
                }

                data.map = data.map || [];
                data.img ? data.map.push(data.img) : null;
                data.collection = data.collection;
                this.setData({ data, article, hasChanged: data.collection })
                console.log(this.data.data)
                resolve(true)
            })
        })

    },
    swiperChange(e) {
        let id = e.currentTarget.id;
        this.setData({
            [id]: e.detail.current
        })
    },
    collectIt() {
        let { id, data } = this.data;
        $http.post('collection', { mark: 'article', id }).then(res => {
            wx.showToast({
                title: `${!!data.collection?'取消成功':'收藏成功'}`,
                icon: 'none'
            });
            data.collection = data.collection == 0 ? 1 : 0;
            this.setData({ data, hasChanged: data.collection })
        })
    },
    makePhoneCall() {
        wx.makePhoneCall({
            phoneNumber: this.data.data.phone,
            fail: res => {}
        })
    },
    getPosterData() {
        return new Promise(resolve => {
            $http.get(`getShare?id=${this.data.id}&path=pages/project/detail`).then(res => {
                console.log(res)
                for (let k in res.data) {
                    this.setData({
                        [k]: res.data[k]
                    })
                }
                resolve(true)
            })
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
    rpxToPx(rpx) {
        return rpx / 750 * wx.getSystemInfoSync().windowWidth;
    },
    hidePoster() {
        this.setData({
            showPoster: false
        })
    },
    destroyQrcode() {
        $http.post('qrcode', { qrcode: this.data.qrcode }).then(res => {
            //do nothing
        })
    },
    keepPoster() {
        wx.saveImageToPhotosAlbum({
            filePath: this.data.poster,
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
    },
    canvasPoster(e) {
        if (this.data.poster) {
            this.setData({
                showPoster: true
            });
            return
        }
        wx.showLoading({
            title: "项目海报生成中...",
            mask: true
        })
        let { avatar, qrcode, data, name, phone } = this.data, { img } = data,
            temp = [];
        let imgs = [img.url, qrcode]
        for (let k = 0; k < imgs.length; k++) {
            temp[k] = this.downloadFile(`${app.globalData.host}${imgs[k]}`)
        }
        Promise.all(temp).then(items => {
            if (items.filter(v => v.statusCode == 200).length == items.length) {
                let imgs = items.map(v => v.tempFilePath);
                const ctx = wx.createCanvasContext("canvas");
                wx.createSelectorQuery().select('#canvas').boundingClientRect(rect => {
                    let { width, height } = rect;
                    ctx.rect(0, 0, width, height);
                    ctx.setFillStyle('#ffffff');
                    ctx.fill();
                    ctx.drawImage(imgs[0], this.rpxToPx(36), this.rpxToPx(34), this.rpxToPx(564), this.rpxToPx(390));
                    ctx.drawImage(rectIcon, this.rpxToPx(526), this.rpxToPx(20), this.rpxToPx(96), this.rpxToPx(94));
                    ctx.save();
                    ctx.beginPath();
                    ctx.setFontSize(this.rpxToPx(28));
                    ctx.setTextAlign("center");
                    ctx.fillStyle = "#000000";
                    ctx.fillText(`${data.title}`, width / 2, this.rpxToPx(490));
                    ctx.setFontSize(this.rpxToPx(20));
                    ctx.setTextAlign("center");
                    ctx.fillStyle = "#B6B6B6";
                    ctx.fillText(`${data.description}`, width / 2, this.rpxToPx(535));
                    ctx.moveTo(this.rpxToPx(36), this.rpxToPx(580));
                    ctx.lineTo(this.rpxToPx(600), this.rpxToPx(580));
                    ctx.lineWidth = this.rpxToPx(2);
                    ctx.strokeStyle = "#B6B6B6";
                    ctx.stroke();
                    ctx.drawImage(imgs[1], this.rpxToPx(124), this.rpxToPx(620), this.rpxToPx(103), this.rpxToPx(103));
                    if (phone) {
                        ctx.drawImage(telIcon, this.rpxToPx(365), this.rpxToPx(642), this.rpxToPx(20), this.rpxToPx(20));
                    }
                    ctx.restore();
                    ctx.setFontSize(this.rpxToPx(24));
                    ctx.fillStyle = "#333333";
                    ctx.fillText(name || '匿名用户', this.rpxToPx(246), this.rpxToPx(660));
                    if (phone) {
                        ctx.fillText(phone, this.rpxToPx(390), this.rpxToPx(660));
                    }
                    ctx.fillText('邀请您加入兆古云', this.rpxToPx(246), this.rpxToPx(700));
                    ctx.restore();
                    ctx.setFontSize(this.rpxToPx(20));
                    ctx.setTextAlign("center");
                    ctx.fillStyle = "#CBCBCB";
                    ctx.fillText('长按识别或扫描二维码进入', width / 2, this.rpxToPx(780));
                    ctx.moveTo(this.rpxToPx(125), this.rpxToPx(772));
                    ctx.lineTo(this.rpxToPx(178), this.rpxToPx(772));
                    ctx.lineWidth = this.rpxToPx(2);
                    ctx.strokeStyle = "#CBCBCB";
                    ctx.stroke();
                    ctx.moveTo(this.rpxToPx(462), this.rpxToPx(772));
                    ctx.lineTo(this.rpxToPx(515), this.rpxToPx(772));
                    ctx.lineWidth = this.rpxToPx(2);
                    ctx.strokeStyle = "#CBCBCB";
                    ctx.stroke();

                    ctx.draw(true, () => {
                        setTimeout(() => {
                            wx.canvasToTempFilePath({
                                canvasId: "canvas",
                                success: res => {
                                    // this.destroyQrcode();
                                    let tempFilePath = res.tempFilePath;
                                    if (tempFilePath !== "") {
                                        this.setData({
                                            showPoster: true,
                                            poster: tempFilePath
                                        });
                                    }
                                    wx.hideLoading();
                                },
                                fail: () => {
                                    wx.showToast({
                                        title: "项目海报生成失败",
                                        icon: "none"
                                    })
                                }
                            });
                        }, 100);
                    })
                }).exec()
            } else {
                wx.showToast({
                    title: "项目海报生成失败",
                    icon: "none"
                })
            }
        })
    },
    onShareAppMessage() {
        let share = util.shareMiniProgram();
        share['title'] = this.data.data.title;
        share['imageUrl'] = this.data.poster;
        return share;
    },
    updatePrePageParams() {
        let pages = getCurrentPages();
        if (pages.length > 1) {
            let prePage = pages[pages.length - 2],
                params = {
                    changed: this.data.hasChanged,
                    id: this.data.id,
                };
            if (prePage.needUpdateList) {
                prePage.needUpdateList(params);
            };
        }
    },
    onUnload: function() {
        this.updatePrePageParams();
    },
    tapDocument() {
        wx.showToast({
            title: '敬请期待',
            icon: 'none'
        })
    },
    showMoreFun() {
        this.setData({ showMore: true })
    }
})