// pages/mine/project.js
const app = getApp();
import $http from '../../utils/request';
import { $stopWuxRefresher, $stopWuxLoader } from '../../components/index';
import regeneratorRuntime from '../../regenerator/runtime.js';
Page({

    /**
     * 页面的初始数据
     */
    data: {
        host: app.globalData.host,
        disabled: false,
        list: [],
        lastPage: null,
        pageNum: 1,
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function(options) {
        let { type, title } = options;
        this.setData({ type });
        wx.setNavigationBarTitle({ title: title || '项目列表' })
        console.log(options)
        this.initData(true);
    },
    initData(loading, flag, page_num) {
        return new Promise(resolve => {
            this.setData({ disabled: true });
            let { list } = this.data;
            page_num = page_num || 1;
            loading ? wx.showLoading({
                title: '加载中',
                mask: true
            }) : null;
            $http.get(`${this.data.type}?page=${page_num}`).then(res => {
                if (!res.error) {
                    let data = res.data.data;
                    this.setData({
                        list: flag ? [...list, ...data] : data,
                        lastPage: res.data.last_page,
                        pageNum: page_num,
                        disabled: false
                    }, () => {
                        loading ? wx.hideLoading() : null;
                    })
                    console.log(this.data.list)
                } else {
                    if (this.data.callFlag == 'refresh') {
                        $stopWuxRefresher(true, `#scroll`);
                    } else if (this.data.callFlag == 'loadmore') {
                        $stopWuxLoader(false, `#scroll`);
                    };
                    this.setData({ disabled: false })
                }
                resolve(true)
            })
        })
    },
    async loadMore() {
        this.data.callFlag = 'loadmore';
        let { pageNum, lastPage } = this.data;
        if (pageNum < lastPage) {
            let page_num = pageNum;
            await this.initData(false, true, ++page_num)
            $stopWuxLoader(false, `#scroll`);
        } else {
            $stopWuxLoader(true, `#scroll`);
        };
    },
    async refreshData() {
        this.data.callFlag = 'refresh';
        await this.initData();
        $stopWuxRefresher(false, `#scroll`);
    },
    needUpdateList(params) {
        console.log(params)
        if (!params.changed && this.data.type == 'myAllArticles') {
            let array = this.data.list;
            array.forEach((v, i) => {
                if (v.id == params.id) {
                    array.splice(i, 1);
                }
            });
            this.setData({
                list: array
            });
        }
    },
})