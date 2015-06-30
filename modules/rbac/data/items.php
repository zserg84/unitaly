<?php
return [
    'accessBackend' => [
        'type' => 2,
        'description' => 'Доступ в админку (не удалять)',
        'data' => 'Доступ в админку',
    ],
    'administrateRbac' => [
        'type' => 2,
        'description' => 'Управление доступом (Админка)',
        'data' => 'Права доступа',
        'children' => [
            'BRoles',
            'BPermissions',
            'BRules',
        ],
    ],
    'BViewRoles' => [
        'type' => 2,
        'description' => 'Просмотр ролей (Админка)',
        'data' => 'Просмотр',
    ],
    'BCreateRoles' => [
        'type' => 2,
        'description' => 'Создание',
        'data' => 'Создание',
    ],
    'BUpdateRoles' => [
        'type' => 2,
        'description' => 'Редактирование ролей',
        'data' => 'Редактирование',
    ],
    'BDeleteRoles' => [
        'type' => 2,
        'description' => 'Удаление',
        'data' => 'Удаление',
    ],
    'BViewPermissions' => [
        'type' => 2,
        'description' => 'Просмотр прав доступа (Админка)',
        'data' => 'Просмотр',
    ],
    'BCreatePermissions' => [
        'type' => 2,
        'description' => 'Can create permissions',
    ],
    'BUpdatePermissions' => [
        'type' => 2,
        'description' => 'Can update permissions',
        'data' => 'Редактирование',
    ],
    'BDeletePermissions' => [
        'type' => 2,
        'description' => 'Can delete permissions',
    ],
    'BViewRules' => [
        'type' => 2,
        'description' => 'Просмотр правил доступа (Админка)',
        'data' => 'Просмотр',
    ],
    'BCreateRules' => [
        'type' => 2,
        'description' => 'Can create rules',
        'data' => 'Создание',
    ],
    'BUpdateRules' => [
        'type' => 2,
        'description' => 'Can update rules',
        'data' => 'Редактирование',
    ],
    'BDeleteRules' => [
        'type' => 2,
        'description' => 'Can delete rules',
    ],
    'user' => [
        'type' => 1,
        'description' => 'User',
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Admin',
        'children' => [
            'user',
        ],
    ],
    'superadmin' => [
        'type' => 1,
        'description' => 'Super admin',
        'children' => [
            'admin',
            'accessBackend',
            'administrateRbac',
            'administrateDirectories',
            'administrateUsers',
        ],
    ],
    'BViewTour' => [
        'type' => 2,
        'description' => 'Просмотр туров (Админка)',
        'data' => 'Просмотр',
    ],
    'administrateDirectories' => [
        'type' => 2,
        'description' => 'Справочники (Админка)',
        'data' => 'Справочники',
        'children' => [
            'BTour',
            'BTourType',
            'BShowplace',
            'BShowplaceType',
            'BLang',
            'BTranslation',
            'BCity',
            'BRegion',
            'BHub',
            'BPlacement',
            'BPlacementType',
            'BRestaurant',
            'BCafe',
            'BRoom',
            'BProvince',
            'BPlacementOptions',
            'BRoomOptions',
            'BTourOptions',
            'BRoomType',
            'BShop',
            'BShopType',
            'BShopCategory',
            'BManufacture',
            'BManufactureType',
        ],
    ],
    'BViewShowplace' => [
        'type' => 2,
        'description' => 'Просмотр достопримечательностей (Админка)',
        'data' => 'Просмотр',
    ],
    'BCreateShowplace' => [
        'type' => 2,
        'description' => 'Can create backend showplaces',
        'data' => 'Создание',
    ],
    'BUpdateShowplace' => [
        'type' => 2,
        'description' => 'Can update backend showplaces',
        'data' => 'Редактирование',
    ],
    'BDeleteShowplace' => [
        'type' => 2,
        'description' => 'Can delete backend showplaces',
        'data' => 'Удаление',
    ],
    'BViewShowplaceType' => [
        'type' => 2,
        'description' => 'Просмотр типов достопримечательностей (Админка)',
        'data' => 'Просмотр',
    ],
    'BCreateShowplaceType' => [
        'type' => 2,
        'description' => 'Can create backend showplace types',
        'data' => 'Создание',
    ],
    'BUpdateShowplaceType' => [
        'type' => 2,
        'description' => 'Can update backend showplace types',
        'data' => 'Редактирование',
    ],
    'BDeleteShowplaceType' => [
        'type' => 2,
        'description' => 'Can delete backend showplace types',
        'data' => 'Удаление',
    ],
    'BViewTourType' => [
        'type' => 2,
        'description' => 'Просмотр типов туров (Админка)',
        'data' => 'Просмотр',
    ],
    'BCreateTourType' => [
        'type' => 2,
        'description' => 'Can create backend tour types',
        'data' => 'Создание',
    ],
    'BUpdateTourType' => [
        'type' => 2,
        'description' => 'Can update backend tour types',
        'data' => 'Редактирование',
    ],
    'BDeleteTourType' => [
        'type' => 2,
        'description' => 'Can delete backend tour types',
        'data' => 'Удаление',
    ],
    'BViewLang' => [
        'type' => 2,
        'description' => 'Просмотр языков (Админка)',
        'data' => 'Просмотр',
    ],
    'BCreateLang' => [
        'type' => 2,
        'description' => 'Can create backend lang',
        'data' => 'Создание',
    ],
    'BUpdateLang' => [
        'type' => 2,
        'description' => 'Can update backend lang',
        'data' => 'Редактирование',
    ],
    'BDeleteLang' => [
        'type' => 2,
        'description' => 'Can delete backend lang',
        'data' => 'Удаление',
    ],
    'BViewTranslation' => [
        'type' => 2,
        'description' => 'Просмотр переводов (Админка)',
        'data' => 'Просмотр',
    ],
    'BCreateTranslation' => [
        'type' => 2,
        'description' => 'Can create backend translations',
        'data' => 'Создание',
    ],
    'BUpdateTranslation' => [
        'type' => 2,
        'description' => 'Can update backend translations',
        'data' => 'Редактирование',
    ],
    'BDeleteTranslation' => [
        'type' => 2,
        'description' => 'Can delete backend translations',
        'data' => 'Удаление',
    ],
    'BViewCity' => [
        'type' => 2,
        'description' => 'Просмотр городов (Админка)',
        'data' => 'Просмотр',
    ],
    'BCreateCity' => [
        'type' => 2,
        'description' => 'Can create backend cities',
        'data' => 'Создание',
    ],
    'BUpdateCity' => [
        'type' => 2,
        'description' => 'Can update backend cities',
        'data' => 'Редактирование',
    ],
    'BDeleteCity' => [
        'type' => 2,
        'description' => 'Can delete backend cities',
        'data' => 'Удаление',
    ],
    'BViewRegion' => [
        'type' => 2,
        'description' => 'Просмотр регионов(Админка)',
        'data' => 'Просмотр',
    ],
    'BCreateRegion' => [
        'type' => 2,
        'description' => 'Can create backend regions',
        'data' => 'Создание',
    ],
    'BUpdateRegion' => [
        'type' => 2,
        'description' => 'Can update backend regions',
        'data' => 'Редактирование',
    ],
    'BDeleteRegion' => [
        'type' => 2,
        'description' => 'Can delete backend regions',
        'data' => 'Удаление',
    ],
    'BCreatePlacementType' => [
        'type' => 2,
        'description' => 'Can create placement type',
        'data' => 'Создание',
    ],
    'BViewPlacementType' => [
        'type' => 2,
        'description' => 'Просмотр типов размещения (Админка)',
        'data' => 'Просмотр',
    ],
    'BUpdatePlacementType' => [
        'type' => 2,
        'description' => 'Can update placement type',
        'data' => 'Редактирование',
    ],
    'BDeletePlacementType' => [
        'type' => 2,
        'description' => 'Can delete placement type',
        'data' => 'Удаление',
    ],
    'BCreateRestaurant' => [
        'type' => 2,
        'description' => 'Can create restaurant',
        'data' => 'Создание',
    ],
    'BUpdateRestaurant' => [
        'type' => 2,
        'description' => 'Can delete backend tour types',
        'data' => 'Редактирование',
    ],
    'BDeleteRestaurant' => [
        'type' => 2,
        'description' => 'Can delete backend tour types',
    ],
    'BViewRestaurant' => [
        'type' => 2,
        'description' => 'Просмотр ресторанов (Админка)',
        'data' => 'Просмотр',
    ],
    'BViewHub' => [
        'type' => 2,
        'description' => 'Просмотр хабов (Админка)',
        'data' => 'Просмотр',
    ],
    'BCreateHub' => [
        'type' => 2,
        'description' => 'Can create backend hubs',
        'data' => 'Создание',
    ],
    'BUpdateHub' => [
        'type' => 2,
        'description' => 'Can update backend cities',
        'data' => 'Редактирование',
    ],
    'BDeleteHub' => [
        'type' => 2,
        'description' => 'Can delete backend cities',
        'data' => 'Удаление',
    ],
    'BCreateTour' => [
        'type' => 2,
        'description' => 'Can create backend tours',
        'data' => 'Создание',
    ],
    'BUpdateTour' => [
        'type' => 2,
        'description' => 'Can update backend tours',
        'data' => 'Редактирование',
    ],
    'BDeleteTour' => [
        'type' => 2,
        'description' => 'Can delete backend tours',
        'data' => 'Удаление',
    ],
    'BCreatePlacement' => [
        'type' => 2,
        'description' => 'Can create backend Placement',
        'data' => 'Создание',
    ],
    'BUpdatePlacement' => [
        'type' => 2,
        'description' => 'Can update backend Placement',
        'data' => 'Редактирование',
    ],
    'BDeletePlacement' => [
        'type' => 2,
        'description' => 'Can delete backend Placement',
        'data' => 'Удаление',
    ],
    'BViewPlacement' => [
        'type' => 2,
        'description' => 'Просмотр мест размещения',
        'data' => 'Просмотр',
    ],
    'BCreateRoom' => [
        'type' => 2,
        'description' => 'Can create backend Room',
        'data' => 'Создание',
    ],
    'BUpdateRoom' => [
        'type' => 2,
        'description' => 'Can update backend Room',
        'data' => 'Редактирование',
    ],
    'BDeleteRoom' => [
        'type' => 2,
        'description' => 'Can delete backend Room',
        'data' => 'Удаление',
    ],
    'BViewRoom' => [
        'type' => 2,
        'description' => 'Просмотр номеров',
        'data' => 'Просмотр',
    ],
    'BServiceTour' => [
        'type' => 2,
        'description' => 'Can view backend services of tours',
        'data' => 'Привязка опций',
    ],
    'administrateUsers' => [
        'type' => 2,
        'description' => 'Пользователи (Админка)',
        'data' => 'Пользователи',
        'children' => [
            'BViewUsers',
            'BCreateUsers',
            'BUpdateUsers',
            'BDeleteUsers',
            'viewUsers',
            'createUsers',
            'updateUsers',
            'updateOwnUsers',
            'deleteUsers',
            'deleteOwnUsers',
        ],
    ],
    'BViewUsers' => [
        'type' => 2,
        'description' => 'Просмотр пользователей(Админка)',
        'data' => 'Просмотр',
    ],
    'BCreateUsers' => [
        'type' => 2,
        'description' => 'Can create backend users',
        'data' => 'Создание',
    ],
    'BUpdateUsers' => [
        'type' => 2,
        'description' => 'Can update backend users',
        'data' => 'Редактирование',
    ],
    'BDeleteUsers' => [
        'type' => 2,
        'description' => 'Can delete backend users',
        'data' => 'Удаление',
    ],
    'viewUsers' => [
        'type' => 2,
        'description' => 'Просмотр пользователей',
        'data' => 'Просмотр',
    ],
    'createUsers' => [
        'type' => 2,
        'description' => 'Can create users',
    ],
    'updateUsers' => [
        'type' => 2,
        'description' => 'Can update users',
        'children' => [
            'updateOwnUsers',
        ],
    ],
    'updateOwnUsers' => [
        'type' => 2,
        'description' => 'Can update own user profile',
        'ruleName' => 'author',
    ],
    'deleteUsers' => [
        'type' => 2,
        'description' => 'Can delete users',
        'children' => [
            'deleteOwnUsers',
        ],
    ],
    'deleteOwnUsers' => [
        'type' => 2,
        'description' => 'Can delete own user profile',
        'ruleName' => 'author',
    ],
    'BTour' => [
        'type' => 2,
        'description' => 'Туры (Админка)',
        'data' => 'Туры',
        'children' => [
            'BViewTour',
            'BCreateTour',
            'BUpdateTour',
            'BDeleteTour',
            'BServiceTour',
        ],
    ],
    'BTourType' => [
        'type' => 2,
        'description' => 'Типы туров (Админка)',
        'data' => 'Типы туров',
        'children' => [
            'BViewTourType',
            'BCreateTourType',
            'BUpdateTourType',
            'BDeleteTourType',
        ],
    ],
    'BShowplace' => [
        'type' => 2,
        'description' => 'Достопримечательности (Админка)',
        'data' => 'Достопримечательности',
        'children' => [
            'BViewShowplace',
            'BCreateShowplace',
            'BUpdateShowplace',
            'BDeleteShowplace',
        ],
    ],
    'BShowplaceType' => [
        'type' => 2,
        'description' => 'Типы достопримечательностей (Админка)',
        'data' => 'Типы достопримечательностей',
        'children' => [
            'BViewShowplaceType',
            'BCreateShowplaceType',
            'BUpdateShowplaceType',
            'BDeleteShowplaceType',
        ],
    ],
    'BLang' => [
        'type' => 2,
        'description' => 'Языки (Админка)',
        'data' => 'Языки',
        'children' => [
            'BViewLang',
            'BCreateLang',
            'BUpdateLang',
            'BDeleteLang',
        ],
    ],
    'BTranslation' => [
        'type' => 2,
        'description' => 'Переводы (Админка)',
        'data' => 'Переводы',
        'children' => [
            'BViewTranslation',
            'BCreateTranslation',
            'BUpdateTranslation',
            'BDeleteTranslation',
        ],
    ],
    'BCity' => [
        'type' => 2,
        'description' => 'Города (Админка)',
        'data' => 'Города',
        'children' => [
            'BViewCity',
            'BCreateCity',
            'BUpdateCity',
            'BDeleteCity',
        ],
    ],
    'BRegion' => [
        'type' => 2,
        'description' => 'Регионы (Админка)',
        'data' => 'Регионы',
        'children' => [
            'BViewRegion',
            'BCreateRegion',
            'BUpdateRegion',
            'BDeleteRegion',
        ],
    ],
    'BHub' => [
        'type' => 2,
        'description' => 'Хабы (Админка)',
        'data' => 'Хабы',
        'children' => [
            'BViewHub',
            'BCreateHub',
            'BUpdateHub',
            'BDeleteHub',
        ],
    ],
    'BPlacement' => [
        'type' => 2,
        'description' => 'Места размещения (Админка)',
        'data' => 'Места размещения',
        'children' => [
            'BCreatePlacement',
            'BUpdatePlacement',
            'BDeletePlacement',
            'BViewPlacement',
        ],
    ],
    'BPlacementType' => [
        'type' => 2,
        'description' => 'Типы мест размещения (Админка)',
        'data' => 'Типы мест размещения',
        'children' => [
            'BCreatePlacementType',
            'BViewPlacementType',
            'BUpdatePlacementType',
            'BDeletePlacementType',
        ],
    ],
    'BRestaurant' => [
        'type' => 2,
        'description' => 'Рестораны (Админка)',
        'data' => 'Рестораны',
        'children' => [
            'BCreateRestaurant',
            'BUpdateRestaurant',
            'BDeleteRestaurant',
            'BViewRestaurant',
        ],
    ],
    'BCafe' => [
        'type' => 2,
        'description' => 'Кафе (Админка)',
        'data' => 'Кафе',
        'children' => [
            'BViewCafe',
            'BCreateCafe',
            'BUpdateCafe',
            'BDeleteCafe',
            'BServiceCafe',
        ],
    ],
    'BRoom' => [
        'type' => 2,
        'description' => 'Номерной фонд (Админка)',
        'data' => 'Номерной фонд',
        'children' => [
            'BCreateRoom',
            'BUpdateRoom',
            'BDeleteRoom',
            'BViewRoom',
        ],
    ],
    'BRoles' => [
        'type' => 2,
        'description' => 'Роли (Админка)',
        'data' => 'Роли',
        'children' => [
            'BViewRoles',
            'BCreateRoles',
            'BUpdateRoles',
            'BDeleteRoles',
        ],
    ],
    'BPermissions' => [
        'type' => 2,
        'description' => 'Права доступа (Админка)',
        'data' => 'Права доступа',
        'children' => [
            'BViewPermissions',
            'BCreatePermissions',
            'BUpdatePermissions',
            'BDeletePermissions',
        ],
    ],
    'BRules' => [
        'type' => 2,
        'description' => 'Правила доступа (Админка)',
        'data' => 'Правила доступа',
        'children' => [
            'BViewRules',
            'BCreateRules',
            'BUpdateRules',
            'BDeleteRules',
        ],
    ],
    'BProvince' => [
        'type' => 2,
        'description' => 'Провинции  (Админка)',
        'data' => 'Провинции',
        'children' => [
            'BViewProvince',
            'BCreateProvince',
            'BUpdateProvince',
            'BDeleteProvince',
        ],
    ],
    'BViewProvince' => [
        'type' => 2,
        'description' => 'Просмотр провинций (Админка)',
        'data' => 'Просмотр',
    ],
    'BCreateProvince' => [
        'type' => 2,
        'description' => 'Создание провинций (Админка)',
        'data' => 'Создание',
    ],
    'BUpdateProvince' => [
        'type' => 2,
        'description' => 'Редактирование провинций (Админка)',
        'data' => 'Редактирование',
    ],
    'BDeleteProvince' => [
        'type' => 2,
        'description' => 'Удаление провинции (Админка)',
        'data' => 'Удаление',
    ],
    'BViewCafe' => [
        'type' => 2,
        'description' => 'Просмотр кафе (Админка)',
        'data' => 'Просмотр',
    ],
    'BCreateCafe' => [
        'type' => 2,
        'description' => 'Создание кафе (Админка)',
        'data' => 'Создание',
    ],
    'BUpdateCafe' => [
        'type' => 2,
        'description' => 'Редактирование кафе (Админка)',
        'data' => 'Редактирование',
    ],
    'BDeleteCafe' => [
        'type' => 2,
        'description' => 'Удаление кафе (Админка)',
        'data' => 'Удаление',
    ],
    'BServiceCafe' => [
        'type' => 2,
        'data' => 'Привязка опций',
    ],
    'BCreatePlacementOptions' => [
        'type' => 2,
        'data' => 'Создание',
    ],
    'BUpdatePlacementOptions' => [
        'type' => 2,
        'data' => 'Редактирование',
    ],
    'BViewPlacementOptions' => [
        'type' => 2,
        'data' => 'Просмотр',
    ],
    'BDeletePlacementOptions' => [
        'type' => 2,
        'data' => 'Удаление',
    ],
    'BPlacementOptions' => [
        'type' => 2,
        'data' => 'Опции мест размещения',
        'children' => [
            'BCreatePlacementOptions',
            'BUpdatePlacementOptions',
            'BViewPlacementOptions',
            'BDeletePlacementOptions',
        ],
    ],
    'BViewRoomOptions' => [
        'type' => 2,
        'data' => 'Просмотр',
    ],
    'BCreateRoomOptions' => [
        'type' => 2,
        'data' => 'Создание',
    ],
    'BUpdateRoomOptions' => [
        'type' => 2,
        'data' => 'Редактирование',
    ],
    'BDeleteRoomOptions' => [
        'type' => 2,
        'data' => 'Удаление',
    ],
    'BRoomOptions' => [
        'type' => 2,
        'data' => 'Опции  номеров',
        'children' => [
            'BViewRoomOptions',
            'BCreateRoomOptions',
            'BUpdateRoomOptions',
            'BDeleteRoomOptions',
        ],
    ],
    'BViewTourOptions' => [
        'type' => 2,
        'data' => 'Просмотр',
    ],
    'BCreateTourOptions' => [
        'type' => 2,
        'data' => 'Создание',
    ],
    'BUpdateTourOptions' => [
        'type' => 2,
        'data' => 'Редактирование',
    ],
    'BDeleteTourOptions' => [
        'type' => 2,
        'data' => 'Удаление',
    ],
    'BTourOptions' => [
        'type' => 2,
        'data' => 'Опции тура',
        'children' => [
            'BViewTourOptions',
            'BCreateTourOptions',
            'BUpdateTourOptions',
            'BDeleteTourOptions',
        ],
    ],
    'BViewRoomType' => [
        'type' => 2,
        'data' => 'Просмотр',
    ],
    'BCreateRoomType' => [
        'type' => 2,
        'data' => 'Создание',
    ],
    'BUpdateRoomType' => [
        'type' => 2,
        'data' => 'Редактирование',
    ],
    'BDeleteRoomType' => [
        'type' => 2,
        'data' => 'Удаление',
    ],
    'BRoomType' => [
        'type' => 2,
        'data' => 'Типы номеров',
        'children' => [
            'BViewRoomType',
            'BCreateRoomType',
            'BUpdateRoomType',
            'BDeleteRoomType',
        ],
    ],
    'BViewShop' => [
        'type' => 2,
        'data' => 'Просмотр',
    ],
    'BCreateShop' => [
        'type' => 2,
        'data' => 'Создание',
    ],
    'BUpdateShop' => [
        'type' => 2,
        'data' => 'Редактирование',
    ],
    'BDeleteShop' => [
        'type' => 2,
        'data' => 'Удаление',
    ],
    'BShop' => [
        'type' => 2,
        'data' => 'Магазины',
        'children' => [
            'BViewShop',
            'BCreateShop',
            'BUpdateShop',
            'BDeleteShop',
        ],
    ],
    'BCreateShopType' => [
        'type' => 2,
        'data' => 'Создание',
    ],
    'BViewShopType' => [
        'type' => 2,
        'data' => 'Просмотр',
    ],
    'BUpdateShopType' => [
        'type' => 2,
        'data' => 'Редактирование',
    ],
    'BDeleteShopType' => [
        'type' => 2,
        'data' => 'Удаление',
    ],
    'BShopType' => [
        'type' => 2,
        'data' => 'Типы магазинов',
        'children' => [
            'BCreateShopType',
            'BViewShopType',
            'BUpdateShopType',
            'BDeleteShopType',
        ],
    ],
    'BViewShopCategory' => [
        'type' => 2,
        'data' => 'Просмотр',
    ],
    'BCreateShopCategory' => [
        'type' => 2,
        'data' => 'Создание',
    ],
    'BUpdateShopCategory' => [
        'type' => 2,
        'data' => 'Редактирование',
    ],
    'BDeleteShopCategory' => [
        'type' => 2,
        'data' => 'Удаление',
    ],
    'BShopCategory' => [
        'type' => 2,
        'data' => 'Категории магазинов',
        'children' => [
            'BViewShopCategory',
            'BCreateShopCategory',
            'BUpdateShopCategory',
            'BDeleteShopCategory',
        ],
    ],
    'BViewManufacture' => [
        'type' => 2,
        'data' => 'Просмотр',
    ],
    'BCreateManufacture' => [
        'type' => 2,
        'data' => 'Создание',
    ],
    'BUpdateManufacture' => [
        'type' => 2,
        'data' => 'Редактирование',
    ],
    'BDeleteManufacture' => [
        'type' => 2,
        'data' => 'Удаление',
    ],
    'BManufacture' => [
        'type' => 2,
        'data' => 'Производства',
        'children' => [
            'BViewManufacture',
            'BCreateManufacture',
            'BUpdateManufacture',
            'BDeleteManufacture',
        ],
    ],
    'BViewManufactureType' => [
        'type' => 2,
        'data' => 'Просмотр',
    ],
    'BCreateManufactureType' => [
        'type' => 2,
        'data' => 'Создание',
    ],
    'BUpdateManufactureType' => [
        'type' => 2,
        'data' => 'Редактирование',
    ],
    'BDeleteManufactureType' => [
        'type' => 2,
        'data' => 'Удаление',
    ],
    'BManufactureType' => [
        'type' => 2,
        'data' => 'Типы производства',
        'children' => [
            'BViewManufactureType',
            'BCreateManufactureType',
            'BUpdateManufactureType',
            'BDeleteManufactureType',
        ],
    ],
];
