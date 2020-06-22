Component({
    properties: {
        // 是否可以超出滚动
        scroll: {
            type: Boolean,
            value: false
        },
        // 数据源
        tabData: {
            type: Array,
            value: []
        },
        // tab高度
        size: {
            type: Number,
            value: 80,
            observer: "sizeChange"
        },
        // 颜色
        color: {
            type: String,
            value: "",
            observer: "colorChange"
        },
        tabCur: {
            type: Number,
            value: 0,
            observer: "tabCurChange"
        },
        needCount: {
            type: Boolean,
            value: false
        },
        padd:{
            type:String,
            value:''
        },
        key:{
            type:String,
            value:'label'
        },
        scale:{
            type:Number,
            value:1
        }
    },
    data: {
        needTransition: false, // 下划线是否需要过渡动画
        translateX: 0, // 下划 line 的左边距离
        lineWidth: 0, // 下划 line 宽度
        scrollLeft: 0, // scroll-view 左边滚动距离
    },
    methods: {
        /**
         * 切换菜单
         */
        toggleTab(e) {
            this.triggerEvent('change', { current: e.currentTarget.dataset.index });
            this.scrollByIndex(e.currentTarget.dataset.index)
        },
        /**
         * 滑动到指定位置
         * @param tabCur: 当前激活的tabItem的索引
         * @param needTransition: 下划线是否需要过渡动画, 第一次进来应设置为false
         */
        scrollByIndex(tabCur, needTransition = true) {
            try {
                this.setData({
                    isScroll: true
                })

                this.setData({
                    needTransition: needTransition
                });

                let item = this.items[tabCur];

                // 子item宽度
                let chItemWidth = item.width - this.itemPadding * 2;

                // 父item左边距离
                let offsetLeft = item.left;

                if (this.data.scroll) { // 超出滚动的情况
                    // 保持滚动后当前item'尽可能'在屏幕中间
                    let scrollLeft = offsetLeft - (this.windowWidth - item.width) / 2;

                    this.setData({
                        tabCur: tabCur,
                        scrollLeft: scrollLeft,
                        translateX: offsetLeft + this.itemPadding,
                        lineWidth: chItemWidth,
                    })
                } else { // 不超出滚动的情况
                    this.setData({
                        tabCur: tabCur,
                        translateX: offsetLeft + this.itemPadding,
                        lineWidth: chItemWidth,
                    })
                }
            } catch (e) {}
        },
        /**
         *  监听tab高度变化, 最小值为80rpx
         */
        sizeChange(newVal, oldVal) {
            if (newVal <= 80) {
                this.setData({
                    size: 80
                })
            }
        },
        /**
         *  监听颜色变化, 然后调用初始化函数
         */
        colorChange(newVal, oldVal) {
            setTimeout(() => {
                this.init()
            }, 0)
        },
        /**
         *  初始化函数
         */
        init() {
            const { windowWidth } = wx.getSystemInfoSync();

            // 设置屏幕宽度
            this.windowWidth = windowWidth || 375;

            // 动态item的padding大小
            this.itemPadding = this.windowWidth / 375 * 15;

            // 获取每一个tab的宽高信息并存储起来
            let query = this.createSelectorQuery();
            for (let i = 0; i < this.data.tabData.length; i++) {
                query.select(`#item${i}`).boundingClientRect()
            }

            query.exec(function(res) {
                this.items = res;
                this.scrollByIndex(this.data.tabCur, false)
            }.bind(this));
        },
        tabCurChange(newVal, oldVal) {
            this.scrollByIndex(newVal);
        },
    },
    ready() {
        this.init();
    }
})