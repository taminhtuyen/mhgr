<?php
// File: create_complete_models.php

echo "=============================================\n";
echo "🛠  TẠO MODEL FULL OPTION (FILLABLE + RELATIONSHIPS)\n";
echo "=============================================\n\n";

// Cấu hình đầy đủ cho các Model còn thiếu
// 'relations': Định nghĩa mối quan hệ. VD: 'user_id' => 'User' nghĩa là tạo hàm user() belongsTo User.
$modelsConfig = [
    // --- 1. NHÓM USER PROFILES ---
    'UserAdminProfile' => [
        'table' => 'users_admin_profiles',
        'cols'  => ['user_id', 'department_id', 'employee_code', 'position', 'start_date', 'end_date', 'contract_type', 'salary_coefficient', 'notes'],
        'relations' => [
            'user_id' => 'User'
        ]
    ],
    'UserCustomerProfile' => [
        'table' => 'users_customer_profiles',
        'cols'  => ['user_id', 'membership_tier_id', 'loyalty_points', 'total_spent', 'dob', 'gender', 'referral_code', 'referred_by', 'last_purchase_at', 'preferences'],
        'relations' => [
            'user_id' => 'User',
            'membership_tier_id' => 'MembershipTier',
            'referred_by' => 'User' // Người giới thiệu
        ]
    ],
    'UserSocialAccount' => [
        'table' => 'users_social_accounts',
        'cols'  => ['user_id', 'provider', 'provider_id', 'token', 'refresh_token', 'expires_in', 'avatar', 'nickname'],
        'relations' => [
            'user_id' => 'User'
        ]
    ],
    'UserProfitHistory' => [
        'table' => 'user_profit_percentage_history',
        'cols'  => ['user_id', 'old_percentage', 'new_percentage', 'changed_by', 'reason'],
        'relations' => [
            'user_id' => 'User',
            'changed_by' => 'User' // Người thực hiện thay đổi
        ]
    ],
    'UserLeaveSchedule' => [
        'table' => 'user_leave_schedules',
        'cols'  => ['user_id', 'leave_type', 'start_date', 'end_date', 'reason', 'status', 'approved_by', 'rejection_reason'],
        'relations' => [
            'user_id' => 'User',
            'approved_by' => 'User'
        ]
    ],
    'UserSearchHistory' => [
        'table' => 'user_search_history',
        'cols'  => ['user_id', 'keyword', 'filters', 'results_count', 'ip_address', 'device_info'],
        'relations' => [
            'user_id' => 'User'
        ]
    ],

    // --- 2. NHÓM SẢN PHẨM & KHO ---
    'CategoryCollection' => [
        'table' => 'category_collections',
        'cols'  => ['name', 'slug', 'description', 'image', 'status', 'sort_order', 'meta_title', 'meta_description'],
        'relations' => [] // Thường collection nối product qua bảng trung gian, chưa có sẵn FK ở đây
    ],
    'ProductPrice' => [
        'table' => 'product_prices',
        'cols'  => ['product_id', 'price_group_id', 'price', 'currency', 'min_quantity', 'start_date', 'end_date'],
        'relations' => [
            'product_id' => 'Product',
            'price_group_id' => 'PriceGroup'
        ]
    ],
    'ProductSourcing' => [
        'table' => 'product_sourcing',
        'cols'  => ['product_id', 'supplier_id', 'cost_price', 'currency', 'sku_supplier', 'lead_time_days', 'is_primary'],
        'relations' => [
            'product_id' => 'Product',
            'supplier_id' => 'Supplier'
        ]
    ],
    'ProductVideo' => [
        'table' => 'product_videos',
        'cols'  => ['product_id', 'platform', 'url', 'thumbnail', 'title', 'description', 'sort_order', 'status'],
        'relations' => [
            'product_id' => 'Product'
        ]
    ],
    'Packing' => [
        'table' => 'packings',
        'cols'  => ['name', 'description', 'weight', 'dimensions', 'cost', 'image', 'status'],
        'relations' => []
    ],
    'PackingDetail' => [
        'table' => 'packing_detail',
        'cols'  => ['packing_id', 'product_id', 'quantity'],
        'relations' => [
            'packing_id' => 'Packing',
            'product_id' => 'Product'
        ]
    ],

    // --- 3. NHÓM KHUYẾN MÃI ---
    'PromotionRule' => [
        'table' => 'promotion_rules',
        'cols'  => ['promotion_id', 'rule_type', 'conditions', 'actions', 'sort_order'],
        'relations' => [
            'promotion_id' => 'Promotion'
        ]
    ],
    'PromotionRuleProduct' => [
        'table' => 'promotion_rule_products',
        'cols'  => ['promotion_rule_id', 'product_id', 'variation_id', 'excluded'],
        'relations' => [
            'promotion_rule_id' => 'PromotionRule',
            'product_id' => 'Product',
            'variation_id' => 'ProductVariation'
        ]
    ],
    'PromotionInventory' => [
        'table' => 'promotion_inventory',
        'cols'  => ['promotion_id', 'product_id', 'total_quantity', 'sold_quantity', 'reserved_quantity'],
        'relations' => [
            'promotion_id' => 'Promotion',
            'product_id' => 'Product'
        ]
    ],
    'PromotionLogicDictionary' => [
        'table' => 'promotion_logic_dictionary',
        'cols'  => ['code', 'name', 'description', 'parameters_schema', 'handler_class', 'type'],
        'relations' => []
    ],

    // --- 4. LOGISTICS ---
    'ShippingMethod' => [
        'table' => 'shipping_methods',
        'cols'  => ['name', 'code', 'description', 'base_cost', 'cost_per_kg', 'cost_per_km', 'estimated_delivery_days', 'status'],
        'relations' => []
    ],
    'DeliveryAttempt' => [
        'table' => 'delivery_attempts',
        'cols'  => ['shipment_id', 'driver_id', 'attempt_number', 'attempted_at', 'status', 'failure_reason', 'notes', 'proof_image'],
        'relations' => [
            'shipment_id' => 'ShippingShipment',
            'driver_id'   => 'ShippingDriver'
        ]
    ],
    'ShippingManagerReview' => [
        'table' => 'shipping_manager_reviews',
        'cols'  => ['manager_id', 'driver_id', 'shipment_id', 'rating', 'comment', 'review_date'],
        'relations' => [
            'manager_id'  => 'User',
            'driver_id'   => 'ShippingDriver',
            'shipment_id' => 'ShippingShipment'
        ]
    ],

    // --- 5. CONTENT ---
    'News' => [
        'table' => 'news',
        'cols'  => ['title', 'slug', 'summary', 'content', 'thumbnail', 'status', 'published_at', 'author_id', 'is_featured', 'tags'],
        'relations' => [
            'author_id' => 'User'
        ]
    ],
    'Content' => [
        'table' => 'contents',
        'cols'  => ['key', 'title', 'body', 'type', 'status', 'language'],
        'relations' => []
    ],
    'GameLanguage' => [
        'table' => 'game_languages',
        'cols'  => ['code', 'name', 'flag_icon', 'is_active', 'is_default'],
        'relations' => []
    ],
    'GameVoice' => [
        'table' => 'game_voices',
        'cols'  => ['language_id', 'name', 'gender', 'voice_code', 'provider', 'is_active'],
        'relations' => [
            'language_id' => 'GameLanguage'
        ]
    ],
    'GameAudioFile' => [
        'table' => 'game_audio_files',
        'cols'  => ['voice_id', 'content_hash', 'text', 'file_path', 'duration', 'format', 'file_size'],
        'relations' => [
            'voice_id' => 'GameVoice'
        ]
    ],

    // --- 6. OTHER ---
    'BookingProfit' => [
        'table' => 'booking_profit',
        'cols'  => ['order_id', 'total_revenue', 'total_cogs', 'total_shipping_cost', 'total_commission', 'total_discount', 'net_profit', 'profit_margin'],
        'relations' => [
            'order_id' => 'Order'
        ]
    ],
    'ReviewRatingRule' => [
        'table' => 'review_rating_rules',
        'cols'  => ['star_rating', 'reward_points', 'conditions', 'status'],
        'relations' => []
    ],
    'Session' => [
        'table' => 'sessions',
        'cols'  => ['user_id', 'ip_address', 'user_agent', 'payload', 'last_activity'],
        'relations' => [
            'user_id' => 'User'
        ]
    ],
    'QueueJob' => [
        'table' => 'jobs',
        'cols'  => ['queue', 'payload', 'attempts', 'reserved_at', 'available_at', 'created_at'],
        'relations' => []
    ],
];

foreach ($modelsConfig as $modelName => $config) {
    $filePath = "app/Models/{$modelName}.php";
    $tableName = $config['table'];

    // --- 1. Tạo chuỗi Fillable ---
    $fillableStr = "[\n        '" . implode("',\n        '", $config['cols']) . "',\n    ]";

    // --- 2. Tạo chuỗi Casts ---
    $casts = [];
    foreach ($config['cols'] as $col) {
        if (str_contains($col, 'date') || str_contains($col, '_at')) {
            $casts[$col] = 'datetime';
        } elseif (in_array($col, ['preferences', 'filters', 'conditions', 'actions', 'parameters_schema', 'tags'])) {
            $casts[$col] = 'array';
        } elseif (in_array($col, ['is_active', 'is_default', 'is_featured', 'is_primary', 'excluded'])) {
            $casts[$col] = 'boolean';
        }
    }
    $castsStr = "[\n";
    foreach ($casts as $key => $val) {
        $castsStr .= "        '{$key}' => '{$val}',\n";
    }
    $castsStr .= "    ]";

    // --- 3. Tạo chuỗi Relationships ---
    $relationsStr = "";
    if (isset($config['relations'])) {
        foreach ($config['relations'] as $foreignKey => $relatedModel) {
            // Tên hàm: bỏ _id (VD: user_id -> user, category_id -> category)
            $methodName = str_replace('_id', '', $foreignKey);
            // Chuyển camelCase (VD: promoted_by -> promotedBy)
            $methodName = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $methodName))));

            $relationsStr .= "\n    public function {$methodName}(): BelongsTo\n    {\n";
            $relationsStr .= "        return \$this->belongsTo({$relatedModel}::class, '{$foreignKey}');\n";
            $relationsStr .= "    }\n";
        }
    }

    echo ">> Đang ghi đè Model chuẩn: App\\Models\\{$modelName}...\n";

    // --- 4. Nội dung File ---
    $content = "<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class {$modelName} extends Model
{
    use HasFactory;

    protected \$table = '{$tableName}';

    protected \$fillable = {$fillableStr};

    protected \$casts = {$castsStr};
{$relationsStr}";

    if (in_array($tableName, ['game_languages', 'game_voices', 'provinces', 'wards', 'packing_detail'])) {
        $content .= "\n    public \$timestamps = false;\n";
    }

    $content .= "}\n";

    file_put_contents($filePath, $content);
}

echo "\n🎉 HOÀN TẤT! Đã cập nhật 28 Models với đầy đủ Fillable và Relationships.\n";
echo "👉 Hãy chạy: composer dump-autoload\n";
?>
