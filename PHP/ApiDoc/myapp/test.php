<?php  
  
/**
     * @api {POST} ?p=apiAgentRecord&a=getMemberList   获取会员记录列表
     * @apiVersion      1.0.0
     * @apiName         getMemberList
     * @apiGroup        用户类
     * @apiPermission  登录后
     *
     * @apiDescription  获取会员记录列表
     *
     * @apiParam   {Number}   page                          页数，默认为 1
     * @apiParam   {String}   pageSize                      每页条数，默认为 5
     * @apiParam   {String}   searchData                    关键字，默认为''
     *
     * @apiSuccess {Number}   rank_name                     会员等级名称
     * @apiSuccess {String}   user_id                       会员ID
     * @apiSuccess {String}   mobile                        手机号码
     * @apiSuccess {String}   user_name                     会员账号
     * @apiSuccess {String}   nick_name                     会员昵称
     * @apiSuccess {String}   sex                           会员昵称性别
     * @apiSuccess {String}   user_rank                     会员等级
     * @apiSuccess {String}   rank_changeTime               用户等级修改时间
     * @apiSuccess {String}   MemberTime                    首次购买会员时间
     * @apiSuccess {String}   MemberMoney                   首次购买会籍费用
     * @apiSuccess {String}   realname                      真实姓名
     * @apiSuccess {String}   rank_status                   月份,默认为0
     * @apiSuccess {String}   reg_time                      注册时间
     * @apiSuccess {String}   AgentID                       代理ID
     * @apiSuccess {String}   AgentCode                     加盟编码
     * @apiSuccess {String}   IntroduceUserName             介绍人姓名
     *
     * @apiSuccessExample  {json} Response (success):
     * {
     *    "status":0,
     *    "msg":"获取会员记录成功！",
     *    "data":[
     *        {
     *            "rank_name":"男爵会员",
     *            "user_id":"00002151",
     *            "mobile":"18820698877",
     *            "user_name":"18820698877",
     *            "nick_name":"1882069887",
     *            "sex":"1",
     *            "user_rank":"3",
     *            "rank_changeTime":"1489397095",
     *            "MemberTime":"2017-03-13 17:24:55",
     *            "MemberMoney":"10000.00",
     *            "realname":"钟今铎",
     *            "rank_status":"1",
     *            "reg_time":"2016-12-23 14:39:37",
     *            "AgentID":"16",
     *            "AgentCode":"N915",
     *            "IntroduceUserName":""
     *        }
     *    ],
     *    "total":1
     * }
     *
     * @apiErrorExample  {json} Response (error):
     * {
     *    "status":1,
     *    "msg":"您暂无会员会籍记录！",
     *    "data":"",
     *    "total":0
     * }
     */
