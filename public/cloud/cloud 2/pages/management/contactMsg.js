// pages/authen/management/contactMsg.js
Page({

    /**
     * 页面的初始数据
     */
    data: {
        array: ['谷歌', '阿里', '百度', '腾讯'],
        index: 0,
        default: '请选择',
        isAdd:true
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function (options) {

    },
   
    companyChange: function (e) {
        let index = e.detail.value
        let array = this.data.array
        this.setData({
            index,
            default: array[index]
        })
    },

    //点击上传图片
    uploadImg:function(){
        let that=this;
        wx.chooseImage({
            count: 1, // 默认9
            sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
            sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
            success: res => {
                wx.showToast({
                    title: '正在上传...',
                    icon: 'loading',
                    mask: true,
                    duration: 1000
                })
                // 返回选定照片的本地文件路径列表，tempFilePath可以作为img标签的src属性显示图片
                let tempFilePaths = res.tempFilePaths;
                that.setData({
                    isAdd:false,
                    imgSrc: tempFilePaths[0]
                })
            }
        })

    },
    
    /**
     * 生命周期函数--监听页面初次渲染完成
     */
    onReady: function () {

    },

    /**
     * 生命周期函数--监听页面显示
     */
    onShow: function () {

    },

    /**
     * 生命周期函数--监听页面隐藏
     */
    onHide: function () {

    },

    /**
     * 生命周期函数--监听页面卸载
     */
    onUnload: function () {

    },

    /**
     * 页面相关事件处理函数--监听用户下拉动作
     */
    onPullDownRefresh: function () {

    },

    /**
     * 页面上拉触底事件的处理函数
     */
    onReachBottom: function () {

    },

    /**
     * 用户点击右上角分享
     */
    onShareAppMessage: function () {

    }
})