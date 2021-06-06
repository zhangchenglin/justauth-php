<?php
/**
 * @author pfinal南丞
 * @date 2021年06月03日 下午7:25
 */

namespace JustAuth\Config;


use JustAuth\Enums\AuthResponseStatus;
use JustAuth\Exception\AuthException;

class AuthDefaultSource
{

    public $gitee;
    public $github;
    public $weibo;
    public $weixin;
    public $douyin;
    public $qq;
    public $huawei;

    public function __construct()
    {
        $this->gitee  = new class extends AuthSource {
            public function authorize(): string
            {
                return "https://gitee.com/oauth/authorize";
            }

            public function accessToken(): string
            {
                return "https://gitee.com/oauth/token";
            }

            public function userInfo(): string
            {
                return "https://gitee.com/api/v5/user";
            }
        };
        $this->github = new class extends AuthSource {
            public function authorize(): string
            {
                return "https://github.com/login/oauth/authorize";
            }

            public function accessToken(): string
            {
                return "https://github.com/login/oauth/access_token";
            }

            public function userInfo(): string
            {
                return "https://api.github.com/user";
            }
        };
        $this->weibo  = new class extends AuthSource {
            public function authorize(): string
            {
                return "https://api.weibo.com/oauth2/authorize";
            }

            public function accessToken(): string
            {
                return "https://api.weibo.com/oauth2/access_token";
            }

            public function userInfo(): string
            {
                return "https://api.weibo.com/2/users/show.json";
            }

            public function userId(): string
            {
                return "https://api.weibo.com/oauth2/get_token_info?access_token=";
            }
        };
        $this->weixin = new class extends AuthSource {
            public function authorize(): string
            {
                return "https://open.weixin.qq.com/connect/qrconnect";
            }

            public function accessToken(): string
            {
                return "https://api.weixin.qq.com/sns/oauth2/access_token";
            }

            public function userInfo(): string
            {
                return "https://api.weixin.qq.com/sns/userinfo";
            }
        };
        $this->douyin = new class extends AuthSource {
            public function authorize(): string
            {
                return "https://open.douyin.com/platform/oauth/connect/";
            }

            public function accessToken(): string
            {
                return "https://open.douyin.com/oauth/access_token/";
            }

            public function userInfo(): string
            {
                return "https://open.douyin.com/oauth/userinfo/";
            }
        };
        $this->qq     = new class extends AuthSource {
            public function authorize(): string
            {
                return "https://graph.qq.com/oauth2.0/authorize";
            }

            public function accessToken(): string
            {
                return "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code";
            }

            public function userInfo(): string
            {
                return "https://graph.qq.com/user/get_user_info";
            }

            public function getUid()
            {
                return "https://graph.qq.com/oauth2.0/me?access_token=";
            }

            public function getUnionid()
            {
                return "https://graph.qq.com/oauth2.0/me?access_token=";
            }
        };
        $this->huawei = new class extends AuthSource {
            public function authorize(): string
            {
                return "https://oauth-login.cloud.huawei.com/oauth2/v2/authorize";
            }

            public function accessToken(): string
            {
                return "https://oauth-login.cloud.huawei.com/oauth2/v3/token";
            }

            public function userInfo(): string
            {
                return "https://api.cloud.huawei.com/rest.php?nsp_fmt=JSON&nsp_svc=huawei.oauth2.user.getTokenInfo";
            }
        };
    }

    /**
     * @param $driver
     * @return mixed
     */
    public function getConfig($driver)
    {
        if (!property_exists(self::class, $driver)) {
            throw new AuthException(AuthResponseStatus::CONFIG_SOURCE_ERROR());
        }
        return $this->$driver;
    }
}