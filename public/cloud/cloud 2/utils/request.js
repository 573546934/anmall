const app = getApp();
import Fly from './flyio';
let $http = new Fly(),
    token_fly = new Fly();
$http.config = token_fly.config = {
    baseURL: `${app.globalData.host}/api/`,
    headers: {
        'api-token': app.globalData.apiToken,
    }
}
// var flag = 0;

function getToken(request) {
    return new Promise((resolve, reject) => {
        wx.login({
            success: res => {
                token_fly.post('login', {
                    code: res.code,
                    guideId: app.globalData.guideId,
                    friendId: app.globalData.friendId
                }).then(data => {
                    app.globalData.member = data.data.member;
                    app.globalData.guideId = data.data.member.guide_id;
                    request.headers['Member-Token'] = app.globalData.memberToken = data.data.memberToken;
                    resolve(data)
                }).catch(error => {
                    reject(false)
                })
            }
        })
    })
}
$http.interceptors.request.use(
    (request) => {
        if (!app.globalData.memberToken) {
            $http.lock();
            return getToken(request).then(data => {
                $http.unlock();
                return request;
            }).catch(error => {
                $http.unlock();
                return error
            })
        } else {
            request.headers['Member-Token'] = app.globalData.memberToken;
            // if (!flag) {
            //     request.headers['Member-Token'] = '3251e0ae59034bb6b65c15633b488638';
            // } else {
            //     request.headers['Member-Token'] = app.globalData.memberToken
            // }
        }
    }
)
$http.interceptors.response.use(
    (response) => {
        if (response.status >= 200 && response.status < 400) {
            return response.data;
        }
    }, (error) => {
        let { data, status } = error.response;
        if (status == 404) {
            // flag++
            app.globalData.memberToken = null;
            // wx.navigateTo({
            //     url: '/pages/mine/login'
            // })
        }
        wx.showToast({
            title: data.message || '系统异常',
            icon: 'none'
        });
        return Promise.resolve({ data, status, error: true });
    }
)
export default $http;