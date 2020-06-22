// components/search/search.js
var timer;
Component({
    /**
     * 组件的属性列表
     */
    properties: {
        placeholder: {
            type: String,
            value: '搜索需求关键词'
        },
        disabled: {
            type: Boolean,
            value: true
        },
        params: {
            type: String,
            value: 'articles'
        }
    },

    /**
     * 组件的初始数据
     */
    data: {
        value: null
    },

    /**
     * 组件的方法列表
     */
    methods: {
        tapSearch() {
            let { disabled,params } = this.data;
            disabled ? wx.navigateTo({
                url: `/pages/index/search?params=${params}`
            }) : null
        },
        confrim(e){
          let {value} = e.detail;
          value = value.trim();
          if(!value){
            this.setData({value})
            wx.showToast({
              title:'请输入您要搜索的关键字',
              icon:'none'
            })
            return
          };
          this.triggerEvent('confirm',{value})
        },
        inputSync(e){
          this.setData({
            value:e.detail.value
          })
        },
        clear(e){
          clearTimeout(timer)
          this.setData({value:null, focus:false});
          timer = setTimeout(()=>{
            this.setData({focus:true});
          },500)
          this.triggerEvent('clear')
        }
    }
})