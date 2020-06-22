const manager = [{
        label: '上传身份证',
        holder: '请上传身份证',
        value: '',
        flag: 'id_img',
        type: 'nav',
        nav:'./idcard?index=0',
        require: true
    },
    {
        label: '身份证号码',
        holder: '请输入身份证号码',
        value: '',
        flag: 'id_num',
        type: 'idcard',
        require: true
    },
    {
        label: '真实姓名',
        holder: '请输入真实姓名',
        value: '',
        flag: 'name',
        type: 'text',
        require: true
    },
    {
        label: '性别',
        holder: '请选择性别',
        value: '',
        flag: 'sex',
        type: 'radio',
        require: true
    },
    {
        label: '所在城市',
        holder: '请填写所在城市',
        value: '',
        flag: 'city',
        type: 'text',
        require: true
    },
    {
        label: '联系邮箱',
        holder: '请输入联系邮箱',
        value: '',
        flag: 'email',
        type: 'text',
        require: true
    },
    {
        label: '头像',
        value: '',
        flag: 'avatar',
        type: 'avatar'
    },
    {
        label: '公司全称',
        value: '',
        flag: 'company_name',
        type: 'text'
    },
    {
        label: '部门',
        value: '',
        flag: 'department',
        type: 'text'
    },
    {
        label: '您的职务',
        value: '',
        flag: 'job',
        type: 'text'
    },
    {
        label: '上传名片',
        value: '',
        tips: '仅限jpg,png,jpeg,gif格式，文件大小不超过2M',
        flag: 'card',
        type: 'upload'
    },
    {
        label: '阅读并同意《XXX协议》',
        holder: '请阅读并同意《XXX协议》',
        value: '',
        flag: 'status',
        type: 'assignment',
        require: true
    }
];
const owner = [{
        label: '上传身份证',
        holder: '请上传身份证',
        value: '',
        flag: 'id_img',
        type: 'nav',
        nav:'./idcard?index=0',
        require: true
    },
    {
        label: '真实姓名',
        holder: '请输入真实姓名',
        value: '',
        flag: 'name',
        type: 'text',
        require: true
    },
    {
        label: '性别',
        holder: '请选择性别',
        value: '',
        flag: 'sex',
        type: 'radio',
        require: true
    },
    {
        label: '联系电话',
        holder: '请输入联系电话',
        value: '',
        flag: 'phone',
        type: 'text',
        require: true
    },
    {
        label: '所在城市',
        value: '',
        flag: 'city',
        type: 'text'
    },
    {
        label: '公司简称',
        value: '',
        flag: 'company_nickname',
        type: 'text'
    },
    {
        label: '您的职务',
        value: '',
        flag: 'job',
        type: 'text'
    },
    {
        label: '上传名片',
        value: '',
        tips: '仅限jpg,png,jpeg,gif格式，文件大小不超过2M',
        flag: 'card',
        type: 'upload'
    },
    {
        label: '阅读并同意《XXX协议》',
        holder: '请阅读并同意《XXX协议》',
        value: '',
        flag: 'status',
        type: 'assignment',
        require: true
    }
];
const propertyowner = [{
        label: '上传身份证',
        holder: '请上传身份证',
        value: '',
        flag: 'id_img',
        type: 'nav',
        nav:'./idcard?index=0',
        require: true
    },
    {
        label: '真实姓名',
        holder: '请输入真实姓名',
        value: '',
        flag: 'name',
        type: 'text',
        require: true
    },
    {
        label: '性别',
        holder: '请选择性别',
        value: '',
        flag: 'sex',
        type: 'radio',
        require: true
    },
    {
        label: '联系电话',
        holder: '请输入联系电话',
        value: '',
        flag: 'phone',
        type: 'text',
        require: true
    },
    {
        label: '所在城市',
        value: '',
        flag: 'city',
        type: 'text'
    },
    {
        label: '公司简称',
        value: '',
        flag: 'company_nickname',
        type: 'text'
    },
    {
        label: '您的职务',
        value: '',
        flag: 'job',
        type: 'text'
    },
    {
        label: '上传名片',
        value: '',
        tips: '仅限jpg,png,jpeg,gif格式，文件大小不超过2M',
        flag: 'card',
        type: 'upload'
    },
    {
        label: '阅读并同意《XXX协议》',
        holder: '请阅读并同意《XXX协议》',
        value: '',
        flag: 'status',
        type: 'assignment',
        require: true
    }
];
module.exports = {
	manager,
	owner,
	propertyowner
}