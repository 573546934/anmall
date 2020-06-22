// pages/mine/action.js
Page({

    /**
     * 页面的初始数据
     */
    data: {
        actions: [
            { value: 'manager', label: '申请成为经纪人',nav:'./certification?action=manager' },
            { value: 'propertyowner', label: '申请成为产权方',nav:'./type?action=propertyowner' },
            { value: 'owner', label: '申请成为资方',nav:'./type?action=owner' },
            { value: 'service', label: '申请成为服务商',nav:'/pages/serviceProvider/index' }
        ]
    }
})