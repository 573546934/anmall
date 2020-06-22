const app = getApp();
Component({
    properties: {
        refreshSize: {
            type: Number,
            value: 120,
            observer: 'refreshChange'
        },
        needBttm: {
            type: Boolean,
            value: true,
        },
        hasTop: Boolean,
        // 颜色
        bgStyle: {
            type: String,
            value: "",
        },
        bgFlag:Boolean,
        hasTop:Boolean,
        refreshStatus: {
            type: Number,
            value: 0,
            observer: "statusChange"
        },
        disabledPullDown: {
            type: Boolean,
            value: false,
        },
        noData: {
            type: Boolean,
            value: false,
        },
        emptyUrl: {
            type: String,
            value: "./empty.png",
        },
        emptyText: {
            type: String,
            value: "",
        },
        padd: {
            type: String,
            value: ''
        },
        isHome:Boolean,
        setHeight:String
    },
    data: {
        mode: 'refresh', // refresh 和 more 两种模式
        successShow: false, // 显示success
        successTran: false, // 过度success
        // refreshStatus: 0, // 1: 下拉刷新, 2: 松开刷新, 3: 加载中, 4: 加载完成
        move: -51, // movable-view 偏移量
        scrollHeight1: 0, // refresh view 高度负值
        // scrollHeight2: 0, // refresh view - success view 高度负值
        scrollTop: 0,
        refreshText: '',
        statusTimer: null,
        noMoreData: false,
        loadmoreVisbi: false,
        isLoading: false,
        isIPX: app.globalData.isIPX,
        firstPage: false,
        defaultBanner: null
    },
    methods: {
        /**
         * 处理 bindscrolltolower 失效情况
         */
        scroll(e) {
            this.triggerEvent('scroll', { scrollTop: e.detail.scrollTop });
        },
        /**
         * movable-view 滚动监听
         */
        change(e) {
            const { refreshStatus } = this.data;
            // 判断如果状态大于3则返回
            if (refreshStatus >= 3 || this.data.disabledPullDown) {
                return
            }

            let diff = e.detail.y;
            this.triggerEvent('diff', { diff })
            if (diff > -10) {
                this.setData({
                    refreshStatus: 2
                })
            } else {
                this.setData({
                    refreshStatus: 1
                })
            }
        },
        /**
         * movable-view 触摸结束事件
         */
        touchend(e) {
            const { refreshStatus } = this.data;

            if (refreshStatus >= 3 || this.data.disabledPullDown) {
                return
            }

            if (refreshStatus == 2) {
                this.startRefreshByManual();
            } else if (refreshStatus == 1) {
                this.setData({
                    move: this.data.scrollHeight1
                })
            }
        },
        /**
         * 加载更多
         */
        more() {
            if (this.data.noMoreData || this.data.isLoading || !this.data.needBttm) return;
            this.setData({ loadmoreVisbi: true, noMoreData: false, isLoading: true });
            if (!this.properties.end && !this.data.noMoreData) {
                this.setData({
                    mode: 'more',
                })
                this.triggerEvent('loadmore');
            }
        },
        // /**
        //  * 监听 requesting 字段变化, 来处理下拉刷新对应的状态变化
        //  */
        // requestingEnd(newVal, oldVal) {
        //     if (this.data.mode == 'more' || this.data.disabledPullDown) {
        //         return
        //     }

        //     if (oldVal === true && newVal === false) {
        //         this.finishRefreshByManual();
        //     } else {
        //         if (this.data.refreshStatus != 3) {
        //             this.setData({
        //                 refreshStatus: 3,
        //                 move: 0
        //             })
        //         }
        //     }
        // },
        startRefreshByManual() {
            if (this.data.isLoading) return
            wx.vibrateShort();
            this.setData({
                loadmoreVisbi: false,
                refreshStatus: 3,
                move: 0,
                mode: 'refresh',
            });
            // return
            this.triggerEvent('refresh');
        },
        finishRefreshByManual(flag) {
            if (this.data.isLoading || this.data.mode == 'more') return;
            this.setData({
                refreshStatus: !flag ? 4 : 0,
                refreshText: !flag ? '刷新完成' : '',
                move: this.data.scrollHeight1
            });
            if (flag) return;
            // this.showTimer = setTimeout(() => {
            //     this.setData({
            //         successShow: true,
            //     });
            //     this.tranTimer = setTimeout(() => {
            //         this.setData({
            //             successTran: true,
            //             move: this.data.scrollHeight1
            //         });
            //         clearTimeout(this.showTimer)
            //         this.data.statusTimer = setTimeout(() => {
            //             this.setData({
            //                 noMoreData: false,
            //                 refreshStatus: 1,
            //                 successShow: false,
            //                 successTran: false,
            //                 move: this.data.scrollHeight1
            //             });
            //             clearTimeout(this.showTimer)
            //         }, 450)
            //     }, 1000)
            // }, 650)
            // this.showTimer = setTimeout(() => {
            // this.setData({
            //     successShow: true,
            // });
            // this.tranTimer = setTimeout(() => {
            //     this.setData({
            //         successTran: true,
            //         move: this.data.scrollHeight1
            //     });
            //     clearTimeout(this.showTimer)
            // this.data.statusTimer = setTimeout(() => {
            this.setData({
                noMoreData: false,
                refreshStatus: 0,
                successShow: false,
                successTran: false,
                move: this.data.scrollHeight1
            });
            // clearTimeout(this.showTimer)
            // }, 450)
            // }, 1000)
            // }, 650)
        },
        /**
         * 监听下拉刷新高度变化, 如果改变重新初始化参数, 最小高度80rpx
         */
        refreshChange(newVal, oldVal) {
            if (newVal <= 120) {
                this.setData({
                    refreshSize: 120
                })
            }
            setTimeout(() => {
                this.init()
            }, 0)
        },
        statusChange(n, o) {
            if (n == 1) {
                clearTimeout(this.data.statusTimer)
            };
            // this.triggerEvent('status', {new:n, old:o});
        },
        finishLoadMore(flag) {
            if (flag) {
                this.setData({
                    noMoreData: true,
                    isLoading: false
                })
            } else {
                this.setData({
                    noMoreData: false,
                    isLoading: false
                })
            }
        },
        scrollToView(into_view) {
            return new Promise(resolve => {
                this.setData({
                    intoView: into_view ? into_view : 'top-anchor'
                });
                resolve(true)
            })
        },
        /**
         * 初始化scroll组件参数, 动态获取 下拉刷新区域 和 success 的高度
         */
        init() {
            try {
                let query = this.createSelectorQuery();

                query.select("#refresh").boundingClientRect()
                // query.select("#success").boundingClientRect()

                query.exec(function(res) {
                    this.setData({
                        scrollHeight1: -res[0].height,
                        // scrollHeight2: res[1].height - res[0].height,
                        move: -res[0].height
                    })
                }.bind(this));

            } catch (e) {}

        },
        isFirstPage(e) {
            let pages = getCurrentPages(),
                current = pages[pages.length - 1];
            if (current.route.match(/^pages\/(index|new|project|community|mine)\/(index|list)$/i)) {
                this.setData({
                    firstPage: true
                })
            };
        },
        stopScroll() {}
    },

    attached() {
        this.isFirstPage();
        if (!this.data.disabledPullDown) {
            this.init()
        };
    }
})