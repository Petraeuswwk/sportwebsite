<?php
/**
 * Theme translations
 *
 * Provides translations for UI elements across all supported languages.
 *
 * @package SportsWholesale
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get translation for a string based on current language.
 */
function sw_t( $key, $default = '' ) {
    static $translations = null;

    if ( null === $translations ) {
        $translations = [
            // Navigation
            'Home' => [
                'zh_CN' => '首页',
                'en_US' => 'Home',
                'ar'    => 'الرئيسية',
                'es_ES' => 'Inicio',
            ],
            'Products' => [
                'zh_CN' => '产品',
                'en_US' => 'Products',
                'ar'    => 'المنتجات',
                'es_ES' => 'Productos',
            ],
            'All Products' => [
                'zh_CN' => '所有产品',
                'en_US' => 'All Products',
                'ar'    => 'جميع المنتجات',
                'es_ES' => 'Todos los Productos',
            ],
            'Contact' => [
                'zh_CN' => '联系我们',
                'en_US' => 'Contact',
                'ar'    => 'اتصل بنا',
                'es_ES' => 'Contacto',
            ],

            // Category names
            '乒乓球' => [
                'zh_CN' => '乒乓球',
                'en_US' => 'Table Tennis',
                'ar' => 'تنس الطاولة',
                'es_ES' => 'Tenis de Mesa',
            ],
            '乒乓球拍' => [
                'zh_CN' => '乒乓球拍',
                'en_US' => 'Table Tennis Rackets',
                'ar' => 'مضارب تنس الطاولة',
                'es_ES' => 'Raquetas de Tenis de Mesa',
            ],
            '羽毛球' => [
                'zh_CN' => '羽毛球',
                'en_US' => 'Badminton',
                'ar' => 'كرة الريشة',
                'es_ES' => 'Bádminton',
            ],
            '羽毛球拍' => [
                'zh_CN' => '羽毛球拍',
                'en_US' => 'Badminton Rackets',
                'ar' => 'مضارب كرة الريشة',
                'es_ES' => 'Raquetas de Bádminton',
            ],
            '跳绳' => [
                'zh_CN' => '跳绳',
                'en_US' => 'Jump Ropes',
                'ar' => 'حبابب القفز',
                'es_ES' => 'Cuerdas para Saltar',
            ],
            '握力器' => [
                'zh_CN' => '握力器',
                'en_US' => 'Grip Strengtheners',
                'ar' => 'معززات القبضة',
                'es_ES' => 'Fortalecedores de Agarre',
            ],
            '网球' => [
                'zh_CN' => '网球',
                'en_US' => 'Tennis',
                'ar' => 'تنس',
                'es_ES' => 'Tenis',
            ],

            // Product meta labels
            'Material' => [
                'zh_CN' => '材质',
                'en_US' => 'Material',
                'ar' => 'المادة',
                'es_ES' => 'Material',
            ],
            'Dimensions' => [
                'zh_CN' => '尺寸',
                'en_US' => 'Dimensions',
                'ar' => 'الأبعاد',
                'es_ES' => 'Dimensiones',
            ],
            'Box Spec' => [
                'zh_CN' => '箱规',
                'en_US' => 'Box Spec',
                'ar' => 'مواصفات الصندوق',
                'es_ES' => 'Especificación de Caja',
            ],
            'Qty per Box' => [
                'zh_CN' => '每箱数量',
                'en_US' => 'Qty per Box',
                'ar' => 'الكمية لكل صندوق',
                'es_ES' => 'Cantidad por Caja',
            ],
            'Weight' => [
                'zh_CN' => '重量',
                'en_US' => 'Weight',
                'ar' => 'الوزن',
                'es_ES' => 'Peso',
            ],
            'Box Price' => [
                'zh_CN' => '箱价',
                'en_US' => 'Box Price',
                'ar' => 'سعر الصندوق',
                'es_ES' => 'Precio por Caja',
            ],
            'MOQ' => [
                'zh_CN' => '起订量',
                'en_US' => 'MOQ',
                'ar' => 'الحد الأدنى للطلب',
                'es_ES' => 'Cantidad Mínima',
            ],

            // Page titles
            'Product Categories' => [
                'zh_CN' => '产品分类',
                'en_US' => 'Product Categories',
                'ar' => 'فئات المنتجات',
                'es_ES' => 'Categorías de Productos',
            ],
            'Browse our wide range of sports equipment by category' => [
                'zh_CN' => '按分类浏览我们广泛的体育器材',
                'en_US' => 'Browse our wide range of sports equipment by category',
                'ar' => 'تصفح مجموعتنا الواسعة من المعدات الرياضية حسب الفئة',
                'es_ES' => 'Explore nuestra amplia gama de equipos deportivos por categoría',
            ],
            'Featured Products' => [
                'zh_CN' => '精选产品',
                'en_US' => 'Featured Products',
                'ar' => 'المنتجات المميزة',
                'es_ES' => 'Productos Destacados',
            ],
            'Our most popular wholesale items' => [
                'zh_CN' => '我们最受欢迎的批发产品',
                'en_US' => 'Our most popular wholesale items',
                'ar' => 'أكثر منتجاتنا بالجملة شعبية',
                'es_ES' => 'Nuestros artículos mayoristas más populares',
            ],
            'products' => [
                'zh_CN' => '个产品',
                'en_US' => 'products',
                'ar' => 'منتجات',
                'es_ES' => 'productos',
            ],
            'products found' => [
                'zh_CN' => '个产品',
                'en_US' => 'products found',
                'ar' => 'منتجات',
                'es_ES' => 'productos encontrados',
            ],

            // Buttons
            'Browse Products' => [
                'zh_CN' => '浏览产品',
                'en_US' => 'Browse Products',
                'ar' => 'تصفح المنتجات',
                'es_ES' => 'Ver Productos',
            ],
            'Contact Us' => [
                'zh_CN' => '联系我们',
                'en_US' => 'Contact Us',
                'ar' => 'اتصل بنا',
                'es_ES' => 'Contáctenos',
            ],
            'View All Products' => [
                'zh_CN' => '查看所有产品',
                'en_US' => 'View All Products',
                'ar' => 'عرض جميع المنتجات',
                'es_ES' => 'Ver Todos los Productos',
            ],
            'Inquire Now' => [
                'zh_CN' => '立即询价',
                'en_US' => 'Inquire Now',
                'ar' => 'استفسر الآن',
                'es_ES' => 'Consultar Ahora',
            ],
            'Get a Quote' => [
                'zh_CN' => '获取报价',
                'en_US' => 'Get a Quote',
                'ar' => 'احصل على عرض سعر',
                'es_ES' => 'Obtener Cotización',
            ],
            'Clear Filters' => [
                'zh_CN' => '清除筛选',
                'en_US' => 'Clear Filters',
                'ar' => 'مسح الفلاتر',
                'es_ES' => 'Limpiar Filtros',
            ],

            // Sort options
            'Sort: Newest' => [
                'zh_CN' => '排序：最新',
                'en_US' => 'Sort: Newest',
                'ar' => 'ترتيب: الأحدث',
                'es_ES' => 'Ordenar: Más Reciente',
            ],
            'Sort: Price Low to High' => [
                'zh_CN' => '排序：价格从低到高',
                'en_US' => 'Sort: Price Low to High',
                'ar' => 'ترتيب: السعر من الأقل إلى الأعلى',
                'es_ES' => 'Ordenar: Precio Bajo a Alto',
            ],
            'Sort: Price High to Low' => [
                'zh_CN' => '排序：价格从高到低',
                'en_US' => 'Sort: Price High to Low',
                'ar' => 'ترتيب: السعر من الأعلى إلى الأقل',
                'es_ES' => 'Ordenar: Precio Alto a Bajo',
            ],
            'Sort: Name A-Z' => [
                'zh_CN' => '排序：名称 A-Z',
                'en_US' => 'Sort: Name A-Z',
                'ar' => 'ترتيب: الاسم أ-ي',
                'es_ES' => 'Ordenar: Nombre A-Z',
            ],
            'Filter by Material' => [
                'zh_CN' => '按材质筛选',
                'en_US' => 'Filter by Material',
                'ar' => 'تصفية حسب المادة',
                'es_ES' => 'Filtrar por Material',
            ],

            // Features
            'Quality Guaranteed' => [
                'zh_CN' => '品质保证',
                'en_US' => 'Quality Guaranteed',
                'ar' => 'جودة مضمونة',
                'es_ES' => 'Calidad Garantizada',
            ],
            'Fast Shipping' => [
                'zh_CN' => '快速发货',
                'en_US' => 'Fast Shipping',
                'ar' => 'شحن سريع',
                'es_ES' => 'Envío Rápido',
            ],
            'OEM / ODM Service' => [
                'zh_CN' => 'OEM/ODM服务',
                'en_US' => 'OEM / ODM Service',
                'ar' => 'خدمة OEM / ODM',
                'es_ES' => 'Servicio OEM / ODM',
            ],
            'Factory Direct Price' => [
                'zh_CN' => '工厂直销价',
                'en_US' => 'Factory Direct Price',
                'ar' => 'سعر المصنع المباشر',
                'es_ES' => 'Precio Directo de Fábrica',
            ],

            // Hero section
            'High-Quality Sports Equipment at Wholesale Prices' => [
                'zh_CN' => '高品质体育器材批发价格',
                'en_US' => 'High-Quality Sports Equipment at Wholesale Prices',
                'ar' => 'معدات رياضية عالية الجودة بأسعار الجملة',
                'es_ES' => 'Equipo Deportivo de Alta Calidad al Por Mayor',
            ],
            'Your trusted B2B supplier for table tennis, badminton, tennis, pickleball, and jump ropes. Competitive pricing with OEM/ODM services available.' => [
                'zh_CN' => '您值得信赖的B2B供应商，提供乒乓球、乒乓球拍、羽毛球、羽毛球拍、网球、跳绳、握力器等体育器材。具有竞争力的价格，提供OEM/ODM服务。',
                'en_US' => 'Your trusted B2B supplier for table tennis, badminton, tennis, jump ropes, grip strengtheners, and more. Competitive pricing with OEM/ODM services available.',
                'ar' => 'مورداك الموثوق به B2B لتنس الطاولة والكرة الطائرة والتنس وحبال القفز ومعززات القبضة والمزيد. أسعار تنافسية مع خدمات OEM/ODM المتاحة.',
                'es_ES' => 'Su proveedor B2B de confianza para tenis de mesa, bádminton, tenis, cuerdas para saltar, fortalecedores de agarre y más. Precios competitivos con servicios OEM/ODM disponibles.',
            ],

            // CTA
            'Ready to Place a Wholesale Order?' => [
                'zh_CN' => '准备好下批发订单了吗？',
                'en_US' => 'Ready to Place a Wholesale Order?',
                'ar' => 'هل أنت مستعد لطلب بالجملة؟',
                'es_ES' => '¿Listo para Realizar un Pedido Mayorista?',
            ],
            'Contact us today for competitive pricing and custom branding options.' => [
                'zh_CN' => '立即联系我们，获取有竞争力的价格和定制品牌选项。',
                'en_US' => 'Contact us today for competitive pricing and custom branding options.',
                'ar' => 'اتصل بنا اليوم للحصول على أسعار تنافسية وخيارات العلامة التجارية المخصصة.',
                'es_ES' => 'Contáctenos hoy para precios competitivos y opciones de marca personalizada.',
            ],

            // Single product
            'Related Products' => [
                'zh_CN' => '相关产品',
                'en_US' => 'Related Products',
                'ar' => 'منتجات ذات صلة',
                'es_ES' => 'Productos Relacionados',
            ],
            'No products found matching your criteria.' => [
                'zh_CN' => '没有找到符合条件的产品。',
                'en_US' => 'No products found matching your criteria.',
                'ar' => 'لم يتم العثور على منتجات تطابق معاييرك.',
                'es_ES' => 'No se encontraron productos que coincidan con sus criterios.',
            ],
            'No featured products yet.' => [
                'zh_CN' => '暂无精选产品。',
                'en_US' => 'No featured products yet.',
                'ar' => 'لا توجد منتجات مميزة بعد.',
                'es_ES' => 'Aún no hay productos destacados.',
            ],

            // Additional translations
            'Featured' => [
                'zh_CN' => '精选',
                'en_US' => 'Featured',
                'ar' => 'مميز',
                'es_ES' => 'Destacado',
            ],
            'Reference Price' => [
                'zh_CN' => '参考价格',
                'en_US' => 'Reference Price',
                'ar' => 'سعر المرجع',
                'es_ES' => 'Precio de Referencia',
            ],
            'Minimum Order Quantity' => [
                'zh_CN' => '最小起订量',
                'en_US' => 'Minimum Order Quantity',
                'ar' => 'الحد الأدنى للطلب',
                'es_ES' => 'Cantidad Mínima de Pedido',
            ],
            'Product Description' => [
                'zh_CN' => '产品描述',
                'en_US' => 'Product Description',
                'ar' => 'وصف المنتج',
                'es_ES' => 'Descripción del Producto',
            ],
            'Browse our complete catalog of wholesale sports equipment' => [
                'zh_CN' => '浏览我们完整的批发体育器材目录',
                'en_US' => 'Browse our complete catalog of wholesale sports equipment',
                'ar' => 'تصفح كتالوجنا الكامل للمعدات الرياضية بالجملة',
                'es_ES' => 'Explore nuestro catálogo completo de equipos deportivos al por mayor',
            ],

            // Footer translations
            'Your trusted partner for high-quality sports equipment at competitive wholesale prices. Serving clients across the Middle East, Africa, South America, and Europe.' => [
                'zh_CN' => '您值得信赖的合作伙伴，提供高品质体育器材，具有竞争力的批发价格。服务中东、非洲、南美和欧洲的客户。',
                'en_US' => 'Your trusted partner for high-quality sports equipment at competitive wholesale prices. Serving clients across the Middle East, Africa, South America, and Europe.',
                'ar' => 'شريكك الموثوق به للمعدات الرياضية عالية الجودة بأسعار الجملة التنافسية. نخدم العملاء في جميع أنحاء الشرق الأوسط وأفريقيا وأمريكا الجنوبية وأوروبا.',
                'es_ES' => 'Su socio de confianza para equipo deportivo de alta calidad a precios mayoristas competitivos. Sirviendo a clientes en Medio Oriente, África, Sudamérica y Europa.',
            ],
            'Quick Links' => [
                'zh_CN' => '快速链接',
                'en_US' => 'Quick Links',
                'ar' => 'روابط سريعة',
                'es_ES' => 'Enlaces Rápidos',
            ],
            'China' => [
                'zh_CN' => '中国',
                'en_US' => 'China',
                'ar' => 'الصين',
                'es_ES' => 'China',
            ],
            'Follow Us' => [
                'zh_CN' => '关注我们',
                'en_US' => 'Follow Us',
                'ar' => 'تابعنا',
                'es_ES' => 'Síguenos',
            ],
            'OEM & ODM orders welcome. Custom branding available.' => [
                'zh_CN' => '欢迎OEM和ODM订单。可提供定制品牌。',
                'en_US' => 'OEM & ODM orders welcome. Custom branding available.',
                'ar' => 'طلبات OEM و ODM مرحب بها. العلامة التجارية المخصصة متاحة.',
                'es_ES' => 'Se aceptan pedidos OEM y ODM. Marca personalizada disponible.',
            ],
            'All rights reserved.' => [
                'zh_CN' => '版权所有。',
                'en_US' => 'All rights reserved.',
                'ar' => 'جميع الحقوق محفوظة.',
                'es_ES' => 'Todos los derechos reservados.',
            ],
            'B2B Wholesale Sports Equipment Supplier' => [
                'zh_CN' => 'B2B批发体育器材供应商',
                'en_US' => 'B2B Wholesale Sports Equipment Supplier',
                'ar' => 'مورداك المعدات الرياضية بالجملة B2B',
                'es_ES' => 'Proveedor Mayorista de Equipo Deportivo B2B',
            ],

            // Product materials
            '橡胶' => [
                'zh_CN' => '橡胶',
                'en_US' => 'Rubber',
                'ar' => 'مطاط',
                'es_ES' => 'Caucho',
            ],
            '塑料' => [
                'zh_CN' => '塑料',
                'en_US' => 'Plastic',
                'ar' => 'بلاستيك',
                'es_ES' => 'Plástico',
            ],
            'PP 塑料' => [
                'zh_CN' => 'PP 塑料',
                'en_US' => 'PP Plastic',
                'ar' => 'بلاستيك PP',
                'es_ES' => 'Plástico PP',
            ],
            'PP+TPA弹簧' => [
                'zh_CN' => 'PP+TPA弹簧',
                'en_US' => 'PP+TPA Spring',
                'ar' => 'نابض PP+TPA',
                'es_ES' => 'Resorte PP+TPA',
            ],
            'pp+弹簧+单吸卡' => [
                'zh_CN' => 'pp+弹簧+单吸卡',
                'en_US' => 'PP+Spring+Single Suction',
                'ar' => 'PP+نابض+شفط مفرد',
                'es_ES' => 'PP+Resorte+Ventosa Simple',
            ],
            'pp塑料+布' => [
                'zh_CN' => 'pp塑料+布',
                'en_US' => 'PP Plastic+Cloth',
                'ar' => 'بلاستيك PP+قماش',
                'es_ES' => 'Plástico PP+Tela',
            ],
            'pp弹簧海绵' => [
                'zh_CN' => 'pp弹簧海绵',
                'en_US' => 'PP Spring Sponge',
                'ar' => 'إسفنجة نابض PP',
                'es_ES' => 'Esponja de Resorte PP',
            ],
            '尼龙' => [
                'zh_CN' => '尼龙',
                'en_US' => 'Nylon',
                'ar' => 'نايلون',
                'es_ES' => 'Nylon',
            ],
            '尼龙球' => [
                'zh_CN' => '尼龙球',
                'en_US' => 'Nylon Ball',
                'ar' => 'كرة نايلون',
                'es_ES' => 'Pelota de Nylon',
            ],
            'pu尼龙球' => [
                'zh_CN' => 'pu尼龙球',
                'en_US' => 'PU Nylon Ball',
                'ar' => 'كرة نايلون PU',
                'es_ES' => 'Pelota de Nylon PU',
            ],
            '仿尼龙球' => [
                'zh_CN' => '仿尼龙球',
                'en_US' => 'Imitation Nylon Ball',
                'ar' => 'كرة نايلون مقلدة',
                'es_ES' => 'Pelota de Nylon Imitación',
            ],
            '发光尼成球' => [
                'zh_CN' => '发光尼成球',
                'en_US' => 'Luminous Nylon Ball',
                'ar' => 'كرة نايلون متوهجة',
                'es_ES' => 'Pelota de Nylon Luminosa',
            ],
            '台纤尼龙球' => [
                'zh_CN' => '台纤尼龙球',
                'en_US' => 'Table Tennis Nylon Ball',
                'ar' => 'كرة نايلون تنس الطاولة',
                'es_ES' => 'Pelota de Nylon de Tenis de Mesa',
            ],
            '快速尼龙球' => [
                'zh_CN' => '快速尼龙球',
                'en_US' => 'Speed Nylon Ball',
                'ar' => 'كرة نايلون سريعة',
                'es_ES' => 'Pelota de Nylon Rápida',
            ],
            '防风尼龙球' => [
                'zh_CN' => '防风尼龙球',
                'en_US' => 'Windproof Nylon Ball',
                'ar' => 'كرة نايلون مقاومة للرياح',
                'es_ES' => 'Pelota de Nylon Resistente al Viento',
            ],
            '塑料球' => [
                'zh_CN' => '塑料球',
                'en_US' => 'Plastic Ball',
                'ar' => 'كرة بلاستيكية',
                'es_ES' => 'Pelota de Plástico',
            ],
            '塑料棉胶' => [
                'zh_CN' => '塑料棉胶',
                'en_US' => 'Plastic Cotton Rubber',
                'ar' => 'مطاط قطني بلاستيكي',
                'es_ES' => 'Caucho de Algodón Plástico',
            ],
            '木' => [
                'zh_CN' => '木',
                'en_US' => 'Wood',
                'ar' => 'خشب',
                'es_ES' => 'Madera',
            ],
            '杨木' => [
                'zh_CN' => '杨木',
                'en_US' => 'Poplar',
                'ar' => 'حور',
                'es_ES' => 'Álamo',
            ],
            '杨木+5mm板' => [
                'zh_CN' => '杨木+5mm板',
                'en_US' => 'Poplar+5mm Board',
                'ar' => 'حور+لوحة 5 مم',
                'es_ES' => 'Álamo+Tabla 5mm',
            ],
            '杨木+7mm板' => [
                'zh_CN' => '杨木+7mm板',
                'en_US' => 'Poplar+7mm Board',
                'ar' => 'حور+لوحة 7 مم',
                'es_ES' => 'Álamo+Tabla 7mm',
            ],
            '3mm板' => [
                'zh_CN' => '3mm板',
                'en_US' => '3mm Board',
                'ar' => 'لوحة 3 مم',
                'es_ES' => 'Tabla 3mm',
            ],
            '4mm板' => [
                'zh_CN' => '4mm板',
                'en_US' => '4mm Board',
                'ar' => 'لوحة 4 مم',
                'es_ES' => 'Tabla 4mm',
            ],
            '5mm板' => [
                'zh_CN' => '5mm板',
                'en_US' => '5mm Board',
                'ar' => 'لوحة 5 مم',
                'es_ES' => 'Tabla 5mm',
            ],
            '5mm/7mm' => [
                'zh_CN' => '5mm/7mm',
                'en_US' => '5mm/7mm',
                'ar' => '5 مم/7 مم',
                'es_ES' => '5mm/7mm',
            ],
            '7mm板' => [
                'zh_CN' => '7mm板',
                'en_US' => '7mm Board',
                'ar' => 'لوحة 7 مم',
                'es_ES' => 'Tabla 7mm',
            ],
            '8mm板' => [
                'zh_CN' => '8mm板',
                'en_US' => '8mm Board',
                'ar' => 'لوحة 8 مم',
                'es_ES' => 'Tabla 8mm',
            ],
            'ABS' => [
                'zh_CN' => 'ABS',
                'en_US' => 'ABS',
                'ar' => 'ABS',
                'es_ES' => 'ABS',
            ],
            '铁' => [
                'zh_CN' => '铁',
                'en_US' => 'Iron',
                'ar' => 'حديد',
                'es_ES' => 'Hierro',
            ],
            '铝' => [
                'zh_CN' => '铝',
                'en_US' => 'Aluminum',
                'ar' => 'ألمنيوم',
                'es_ES' => 'Aluminio',
            ],
            '玻纤' => [
                'zh_CN' => '玻纤',
                'en_US' => 'Fiberglass',
                'ar' => 'ألياف زجاجية',
                'es_ES' => 'Fibra de Vidrio',
            ],
            '粗毛' => [
                'zh_CN' => '粗毛',
                'en_US' => 'Coarse Hair',
                'ar' => 'شعر خشن',
                'es_ES' => 'Pelo Grueso',
            ],
            '羽毛' => [
                'zh_CN' => '羽毛',
                'en_US' => 'Feather',
                'ar' => 'ريش',
                'es_ES' => 'Pluma',
            ],
            '轴承' => [
                'zh_CN' => '轴承',
                'en_US' => 'Bearing',
                'ar' => 'محمل',
                'es_ES' => 'Rodamiento',
            ],
            '双面牛筋胶皮+8mm板' => [
                'zh_CN' => '双面牛筋胶皮+8mm板',
                'en_US' => 'Double-sided Rubber+8mm Board',
                'ar' => 'مطاط مزدوج+لوحة 8 مم',
                'es_ES' => 'Caucho Doble Cara+Tabla 8mm',
            ],
            '牛筋胶皮 8mm板' => [
                'zh_CN' => '牛筋胶皮 8mm板',
                'en_US' => 'Rubber 8mm Board',
                'ar' => 'مطاط+لوحة 8 مم',
                'es_ES' => 'Caucho+Tabla 8mm',
            ],
            // Approved V5 interface strings.
            'All' => [ 'zh_CN' => '全部', 'ar' => 'الكل', 'es_ES' => 'Todos' ],
            'Ready to ship in about %d days' => [ 'zh_CN' => '预计约 %d 天可发货', 'ar' => 'جاهز للشحن خلال نحو %d أيام', 'es_ES' => 'Listo para enviar en unos %d días' ],
            'FACTORY & WAREHOUSE' => [ 'zh_CN' => '工厂与仓库', 'ar' => 'المصنع والمستودع', 'es_ES' => 'FÁBRICA Y ALMACÉN' ],
            'Warehouse' => [ 'zh_CN' => '仓库', 'ar' => 'المستودع', 'es_ES' => 'Almacén' ],
            'Stringing & quality check' => [ 'zh_CN' => '穿线与质检', 'ar' => 'الشد وفحص الجودة', 'es_ES' => 'Encordado y control de calidad' ],
            'Packing line' => [ 'zh_CN' => '包装线', 'ar' => 'خط التعبئة', 'es_ES' => 'Línea de embalaje' ],
            'Container loading' => [ 'zh_CN' => '装柜', 'ar' => 'تحميل الحاويات', 'es_ES' => 'Carga de contenedores' ],
            'Southeast Asia' => [ 'zh_CN' => '东南亚', 'ar' => 'جنوب شرق آسيا', 'es_ES' => 'Sudeste Asiático' ],
            'Middle East' => [ 'zh_CN' => '中东', 'ar' => 'الشرق الأوسط', 'es_ES' => 'Oriente Medio' ],
            'Central Asia' => [ 'zh_CN' => '中亚', 'ar' => 'آسيا الوسطى', 'es_ES' => 'Asia Central' ],
            'South America' => [ 'zh_CN' => '南美洲', 'ar' => 'أمريكا الجنوبية', 'es_ES' => 'Sudamérica' ],
            'About' => [ 'zh_CN' => '关于我们', 'ar' => 'من نحن', 'es_ES' => 'Nosotros' ],
            'Browse our sports equipment catalog and send a product list for a wholesale quote.' => [ 'zh_CN' => '浏览体育用品目录，发送产品清单获取批发报价。', 'ar' => 'تصفح كتالوج المعدات الرياضية وأرسل قائمة المنتجات للحصول على عرض سعر.', 'es_ES' => 'Explore nuestro catálogo deportivo y envíe una lista de productos para recibir una cotización.' ],
            'Wholesale inquiries' => [ 'zh_CN' => '批发询盘', 'ar' => 'استفسارات الجملة', 'es_ES' => 'Consultas mayoristas' ],
            'Wholesale sports equipment from Yiwu, China' => [
                'zh_CN' => '中国义乌体育用品批发',
                'ar' => 'معدات رياضية بالجملة من ييوو، الصين',
                'es_ES' => 'Artículos deportivos al por mayor desde Yiwu, China',
            ],
            'Racket Sports Wholesale' => [
                'zh_CN' => '球拍运动用品批发',
                'ar' => 'بيع معدات رياضات المضرب بالجملة',
                'es_ES' => 'Deportes de raqueta al por mayor',
            ],
            'for Global Buyers' => [
                'zh_CN' => '面向全球买家',
                'ar' => 'للمشترين حول العالم',
                'es_ES' => 'para compradores globales',
            ],
            'Explore badminton, table tennis, tennis and fitness products. Build a mixed inquiry and ask us about carton pricing, packing and OEM options.' => [
                'zh_CN' => '浏览羽毛球、乒乓球、网球和健身产品。将不同产品加入询盘，了解箱价、包装和OEM选项。',
                'ar' => 'تصفح منتجات الريشة وتنس الطاولة والتنس واللياقة. أرسل استفسارًا مختلطًا عن الأسعار والتعبئة وخيارات التصنيع.',
                'es_ES' => 'Explore bádminton, tenis de mesa, tenis y fitness. Envíe una consulta mixta sobre precios por caja, embalaje y opciones OEM.',
            ],
            'MOQ shown on every product' => [
                'zh_CN' => '每款产品标明起订量',
                'ar' => 'الحد الأدنى للطلب موضح لكل منتج',
                'es_ES' => 'MOQ indicado en cada producto',
            ],
            'Categories' => [
                'zh_CN' => '分类',
                'ar' => 'الفئات',
                'es_ES' => 'Categorías',
            ],
            'Languages' => [
                'zh_CN' => '语言',
                'ar' => 'اللغات',
                'es_ES' => 'Idiomas',
            ],
            'On request' => [
                'zh_CN' => '按需提供',
                'ar' => 'حسب الطلب',
                'es_ES' => 'A solicitud',
            ],
            'Browse by sport and product type' => [
                'zh_CN' => '按运动及产品类型浏览',
                'ar' => 'تصفح حسب الرياضة ونوع المنتج',
                'es_ES' => 'Explore por deporte y tipo de producto',
            ],
            'Compare products, pack sizes and MOQ' => [
                'zh_CN' => '比较产品、箱规和起订量',
                'ar' => 'قارن المنتجات والتعبئة والحد الأدنى للطلب',
                'es_ES' => 'Compare productos, embalajes y MOQ',
            ],
            'No products in this selection.' => [
                'zh_CN' => '此分类暂无产品。',
                'ar' => 'لا توجد منتجات في هذا القسم.',
                'es_ES' => 'No hay productos en esta selección.',
            ],
            'Ask to see packing and dispatch' => [
                'zh_CN' => '了解包装与发货流程',
                'ar' => 'اطلب مشاهدة التعبئة والشحن',
                'es_ES' => 'Conozca el embalaje y el despacho',
            ],
            'We work with partner factories. Request a video call to discuss products, packing and shipping.' => [
                'zh_CN' => '我们与合作工厂协作。可预约视频通话，讨论产品、包装和运输。',
                'ar' => 'نعمل مع مصانع شريكة. اطلب مكالمة فيديو لمناقشة المنتجات والتعبئة والشحن.',
                'es_ES' => 'Trabajamos con fábricas asociadas. Solicite una videollamada para hablar sobre productos, embalaje y envío.',
            ],
            'Book a factory video call' => [
                'zh_CN' => '预约视频看厂',
                'ar' => 'احجز مكالمة فيديو للمصنع',
                'es_ES' => 'Reserve una videollamada con la fábrica',
            ],
            'Reference images. Factory photos to be replaced with verified partner photos before launch.' => [
                'zh_CN' => '示意图片。上线前将替换为经核实的合作工厂实拍。',
                'ar' => 'صور توضيحية. ستستبدل بصور حقيقية للمصانع الشريكة قبل الإطلاق.',
                'es_ES' => 'Imágenes de referencia. Se sustituirán por fotos verificadas de fábricas asociadas antes del lanzamiento.',
            ],
            'Choose & inquire' => [
                'zh_CN' => '选品询盘',
                'ar' => 'اختر واستفسر',
                'es_ES' => 'Elija y consulte',
            ],
            'Add products and quantities to your inquiry.' => [
                'zh_CN' => '将产品和数量加入询盘。',
                'ar' => 'أضف المنتجات والكميات إلى استفسارك.',
                'es_ES' => 'Añada productos y cantidades a su consulta.',
            ],
            'Confirm a quote' => [
                'zh_CN' => '报价确认',
                'ar' => 'تأكيد عرض السعر',
                'es_ES' => 'Confirme la cotización',
            ],
            'We confirm pricing, packing and terms with you.' => [
                'zh_CN' => '与您确认价格、包装及条款。',
                'ar' => 'نؤكد معك الأسعار والتعبئة والشروط.',
                'es_ES' => 'Confirmamos precios, embalaje y condiciones.',
            ],
            'Sample or produce' => [
                'zh_CN' => '打样或生产',
                'ar' => 'عينة أو إنتاج',
                'es_ES' => 'Muestra o producción',
            ],
            'Review samples or confirm production details.' => [
                'zh_CN' => '查看样品或确认生产细节。',
                'ar' => 'راجع العينات أو أكد تفاصيل الإنتاج.',
                'es_ES' => 'Revise muestras o confirme detalles de producción.',
            ],
            'Pack & ship' => [
                'zh_CN' => '装箱发货',
                'ar' => 'التعبئة والشحن',
                'es_ES' => 'Embalaje y envío',
            ],
            'Confirm packing and shipment arrangements.' => [
                'zh_CN' => '确认包装与发货安排。',
                'ar' => 'تأكيد ترتيبات التعبئة والشحن.',
                'es_ES' => 'Confirme el embalaje y el envío.',
            ],
            'What is the minimum order?' => [
                'zh_CN' => '最低起订量是多少？',
                'ar' => 'ما الحد الأدنى للطلب؟',
                'es_ES' => '¿Cuál es el pedido mínimo?',
            ],
            'MOQ varies by product. Check the product page and inquire to confirm carton units.' => [
                'zh_CN' => '起订量因产品而异。请查看产品页并询盘确认箱规单位。',
                'ar' => 'يختلف الحد الأدنى حسب المنتج. راجع صفحة المنتج وتواصل لتأكيد وحدات الكرتون.',
                'es_ES' => 'El MOQ varía según el producto. Consulte la página y confirme las unidades por caja.',
            ],
            'How do payment and shipping work?' => [
                'zh_CN' => '付款和运输如何安排？',
                'ar' => 'كيف يتم الدفع والشحن؟',
                'es_ES' => '¿Cómo funcionan el pago y el envío?',
            ],
            'We confirm payment and EXW or FOB terms in your quotation.' => [
                'zh_CN' => '我们会在报价时确认付款及EXW或FOB条款。',
                'ar' => 'نؤكد شروط الدفع وEXW أو FOB في عرض السعر.',
                'es_ES' => 'Confirmamos el pago y los términos EXW o FOB en la cotización.',
            ],
            'How long is the lead time?' => [
                'zh_CN' => '交期需要多久？',
                'ar' => 'ما مدة التسليم؟',
                'es_ES' => '¿Cuál es el plazo de entrega?',
            ],
            'Lead time depends on product, stock and customization. Ask for a current estimate.' => [
                'zh_CN' => '交期取决于产品、库存和定制需求，请询问当前预计时间。',
                'ar' => 'تعتمد المدة على المنتج والمخزون والتخصيص. اطلب تقديرًا حديثًا.',
                'es_ES' => 'El plazo depende del producto, inventario y personalización. Solicite una estimación.',
            ],
            'Can you print our logo (OEM)?' => [
                'zh_CN' => '可以印制我们的商标吗？',
                'ar' => 'هل يمكن طباعة شعارنا؟',
                'es_ES' => '¿Pueden imprimir nuestro logotipo?',
            ],
            'Logo printing is available on request for volume orders. Send your artwork to discuss options.' => [
                'zh_CN' => '批量订单可询问商标印制，请发送设计稿讨论选项。',
                'ar' => 'تتوفر طباعة الشعار للطلبات الكبيرة حسب الطلب. أرسل التصميم لمناقشة الخيارات.',
                'es_ES' => 'La impresión del logo está disponible bajo consulta para pedidos por volumen. Envíe su diseño.',
            ],
            'Can I request samples?' => [
                'zh_CN' => '可以申请样品吗？',
                'ar' => 'هل يمكن طلب عينات؟',
                'es_ES' => '¿Puedo solicitar muestras?',
            ],
            'Ask us about sample availability and shipping for the products you need.' => [
                'zh_CN' => '请就所需产品咨询样品供应和运费。',
                'ar' => 'اسألنا عن توفر العينات وشحن المنتجات المطلوبة.',
                'es_ES' => 'Consúltenos sobre muestras y envío de los productos que necesita.',
            ],
            'Send your product list and quantities for a tailored quote.' => [
                'zh_CN' => '发送产品清单和数量，获取针对性报价。',
                'ar' => 'أرسل قائمة المنتجات والكميات للحصول على عرض سعر.',
                'es_ES' => 'Envíe su lista de productos y cantidades para una cotización.',
            ],
            'Quantity pricing' => [
                'zh_CN' => '阶梯价格',
                'ar' => 'أسعار حسب الكمية',
                'es_ES' => 'Precios por cantidad',
            ],
            'Colors / styles' => [
                'zh_CN' => '颜色／款式',
                'ar' => 'الألوان / الأنماط',
                'es_ES' => 'Colores / estilos',
            ],
            'Quantity' => [
                'zh_CN' => '数量',
                'ar' => 'الكمية',
                'es_ES' => 'Cantidad',
            ],
            'EXW / FOB — confirm when you inquire' => [
                'zh_CN' => 'EXW／FOB——询盘时确认',
                'ar' => 'EXW / FOB — يتم التأكيد عند الاستفسار',
                'es_ES' => 'EXW / FOB — confirmar al consultar',
            ],
            'Product specifications' => [
                'zh_CN' => '产品参数',
                'ar' => 'مواصفات المنتج',
                'es_ES' => 'Especificaciones del producto',
            ],
            'Packing & shipping' => [
                'zh_CN' => '箱规与运输',
                'ar' => 'التعبئة والشحن',
                'es_ES' => 'Embalaje y envío',
            ],
            'Your logo on request' => [
                'zh_CN' => '可按需印制买家商标',
                'ar' => 'شعارك حسب الطلب',
                'es_ES' => 'Su logo a solicitud',
            ],
            'Ask about logo printing for volume orders.' => [
                'zh_CN' => '批量订单可咨询商标印制。',
                'ar' => 'اسأل عن طباعة الشعار للطلبات الكبيرة.',
                'es_ES' => 'Consulte la impresión del logo para pedidos por volumen.',
            ],
            'Ask about OEM' => [
                'zh_CN' => '咨询OEM',
                'ar' => 'استفسر عن التصنيع حسب الطلب',
                'es_ES' => 'Consultar OEM',
            ],
            'Details & more views' => [
                'zh_CN' => '详情与更多图片',
                'ar' => 'التفاصيل والمزيد من الصور',
                'es_ES' => 'Detalles y más vistas',
            ],
            'Warehouse & packing' => [
                'zh_CN' => '仓库与包装',
                'ar' => 'المستودع والتعبئة',
                'es_ES' => 'Almacén y embalaje',
            ],
            'Reference images. Replace with verified partner photos before launch.' => [
                'zh_CN' => '示意图片。上线前将替换为经核实的合作厂家实拍。',
                'ar' => 'صور توضيحية. ستستبدل بصور الشركاء الحقيقية قبل الإطلاق.',
                'es_ES' => 'Imágenes de referencia. Sustituir por fotos verificadas antes del lanzamiento.',
            ],
            'Provide email or WhatsApp so we can reply.' => [
                'zh_CN' => '请留下邮箱或WhatsApp，以便我们回复。',
                'ar' => 'قدم بريدًا إلكترونيًا أو واتساب للرد عليك.',
                'es_ES' => 'Proporcione correo o WhatsApp para responderle.',
            ],
            'Add to Inquiry Basket' => [
                'zh_CN' => '加入询盘篮',
                'ar' => 'أضف إلى سلة الاستفسارات',
                'es_ES' => 'Añadir a la cesta de consultas',
            ],
        ];
    }

    $lang = sportswholesale_get_current_lang();

    if ( isset( $translations[ $key ][ $lang ] ) ) {
        return $translations[ $key ][ $lang ];
    }

    // Fallback to English, then to the key itself
    if ( isset( $translations[ $key ]['en_US'] ) ) {
        return $translations[ $key ]['en_US'];
    }

    return $default ?: $key;
}

/**
 * Translate category name.
 */
function sw_translate_category( $name ) {
    return sw_t( $name, $name );
}

/**
 * Translate product meta value (material, etc).
 */
function sw_translate_meta( $value ) {
    if ( empty( $value ) ) {
        return $value;
    }
    return sw_t( $value, $value );
}

/**
 * Translate quantity values (e.g., 100套 -> 100 sets).
 */
function sw_translate_quantity( $value ) {
    if ( empty( $value ) ) {
        return $value;
    }

    $units = [
        '套' => [
            'zh_CN' => '套',
            'en_US' => 'sets',
            'ar' => 'طقم',
            'es_ES' => 'juegos',
        ],
        '卡' => [
            'zh_CN' => '卡',
            'en_US' => 'cards',
            'ar' => 'بطاقة',
            'es_ES' => 'tarjetas',
        ],
        '条' => [
            'zh_CN' => '条',
            'en_US' => 'pcs',
            'ar' => 'قطعة',
            'es_ES' => 'piezas',
        ],
        '支' => [
            'zh_CN' => '支',
            'en_US' => 'pcs',
            'ar' => 'قطعة',
            'es_ES' => 'piezas',
        ],
        '个' => [
            'zh_CN' => '个',
            'en_US' => 'pcs',
            'ar' => 'قطعة',
            'es_ES' => 'piezas',
        ],
        '件' => [
            'zh_CN' => '件',
            'en_US' => 'pcs',
            'ar' => 'قطعة',
            'es_ES' => 'piezas',
        ],
        '付' => [
            'zh_CN' => '付',
            'en_US' => 'pairs',
            'ar' => 'زوج',
            'es_ES' => 'pares',
        ],
        '只' => [
            'zh_CN' => '只',
            'en_US' => 'pcs',
            'ar' => 'قطعة',
            'es_ES' => 'piezas',
        ],
        '袋' => [
            'zh_CN' => '袋',
            'en_US' => 'bags',
            'ar' => 'كيس',
            'es_ES' => 'bolsas',
        ],
        '盒' => [
            'zh_CN' => '盒',
            'en_US' => 'boxes',
            'ar' => 'علبة',
            'es_ES' => 'cajas',
        ],
        '桶' => [
            'zh_CN' => '桶',
            'en_US' => 'buckets',
            'ar' => 'دلو',
            'es_ES' => 'cubos',
        ],
        '筒' => [
            'zh_CN' => '筒',
            'en_US' => 'cans',
            'ar' => 'علبة',
            'es_ES' => 'latas',
        ],
        '箱' => [
            'zh_CN' => '箱',
            'en_US' => 'cartons',
            'ar' => 'كرتون',
            'es_ES' => 'cajas',
        ],
        '包' => [
            'zh_CN' => '包',
            'en_US' => 'packs',
            'ar' => 'حزمة',
            'es_ES' => 'paquetes',
        ],
    ];

    $lang = sportswholesale_get_current_lang();

    foreach ( $units as $cn => $translations ) {
        if ( isset( $translations[ $lang ] ) ) {
            $value = str_replace( $cn, $translations[ $lang ], $value );
        }
    }

    return $value;
}

/**
 * Translate price value with units.
 */
function sw_translate_price( $price ) {
    if ( empty( $price ) ) {
        return $price;
    }

    // Price unit translations
    $units = [
        '元/袋' => [
            'zh_CN' => '元/袋',
            'en_US' => 'RMB/bag',
            'ar' => 'ريال/كيس',
            'es_ES' => 'RMB/bolsa',
        ],
        '元/卡' => [
            'zh_CN' => '元/卡',
            'en_US' => 'RMB/card',
            'ar' => 'ريال/بطاقة',
            'es_ES' => 'RMB/tarjeta',
        ],
        '元/条' => [
            'zh_CN' => '元/条',
            'en_US' => 'RMB/pc',
            'ar' => 'ريال/قطعة',
            'es_ES' => 'RMB/pieza',
        ],
        '元/盒' => [
            'zh_CN' => '元/盒',
            'en_US' => 'RMB/box',
            'ar' => 'ريال/علبة',
            'es_ES' => 'RMB/caja',
        ],
        '元/支' => [
            'zh_CN' => '元/支',
            'en_US' => 'RMB/pc',
            'ar' => 'ريال/قطعة',
            'es_ES' => 'RMB/pieza',
        ],
        '元/筒' => [
            'zh_CN' => '元/筒',
            'en_US' => 'RMB/can',
            'ar' => 'ريال/علبة',
            'es_ES' => 'RMB/lata',
        ],
        '元/件' => [
            'zh_CN' => '元/件',
            'en_US' => 'RMB/pc',
            'ar' => 'ريال/قطعة',
            'es_ES' => 'RMB/pieza',
        ],
        '元/套' => [
            'zh_CN' => '元/套',
            'en_US' => 'RMB/set',
            'ar' => 'ريال/طقم',
            'es_ES' => 'RMB/juego',
        ],
        '元/桶' => [
            'zh_CN' => '元/桶',
            'en_US' => 'RMB/bucket',
            'ar' => 'ريال/دلو',
            'es_ES' => 'RMB/cubo',
        ],
        '元/个' => [
            'zh_CN' => '元/个',
            'en_US' => 'RMB/pc',
            'ar' => 'ريال/قطعة',
            'es_ES' => 'RMB/pieza',
        ],
        '元' => [
            'zh_CN' => '元',
            'en_US' => 'RMB',
            'ar' => 'ريال',
            'es_ES' => 'RMB',
        ],
    ];

    $lang = sportswholesale_get_current_lang();

    foreach ( $units as $cn => $translations ) {
        if ( isset( $translations[ $lang ] ) ) {
            $price = str_replace( $cn, $translations[ $lang ], $price );
        }
    }

    return $price;
}

/**
 * Translate MOQ value.
 */
function sw_translate_moq( $moq ) {
    if ( empty( $moq ) ) {
        return $moq;
    }

    // If MOQ is just a number, add carton unit
    if ( is_numeric( $moq ) ) {
        $lang = sportswholesale_get_current_lang();
        $units = [
            'zh_CN' => '箱',
            'en_US' => 'cartons',
            'ar' => 'كرتون',
            'es_ES' => 'cajas',
        ];
        return $moq . ' ' . ( isset( $units[ $lang ] ) ? $units[ $lang ] : 'cartons' );
    }

    // Translate Chinese MOQ text
    $moq_translations = [
        '数量多少定价格' => [
            'zh_CN' => '数量多少定价格',
            'en_US' => 'Price depends on quantity',
            'ar' => 'السعر يعتمد على الكمية',
            'es_ES' => 'El precio depende de la cantidad',
        ],
    ];

    $lang = sportswholesale_get_current_lang();
    foreach ( $moq_translations as $cn => $translations ) {
        if ( $moq === $cn && isset( $translations[ $lang ] ) ) {
            return $translations[ $lang ];
        }
    }

    return $moq;
}

/**
 * Filter product content to translate material values and prices.
 */
add_filter( 'the_content', function ( $content ) {
    if ( is_singular( 'product' ) || is_post_type_archive( 'product' ) || is_tax( 'product_category' ) ) {
        // Get all material values
        $materials = [
            '橡胶', '塑料', 'PP 塑料', 'PP+TPA弹簧', 'pp+弹簧+单吸卡',
            'pp塑料+布', 'pp弹簧海绵', '尼龙', '尼龙球', 'pu尼龙球',
            '仿尼龙球', '发光尼成球', '台纤尼龙球', '快速尼龙球', '防风尼龙球',
            '塑料球', '塑料棉胶', '木', '杨木', '杨木+5mm板', '杨木+7mm板',
            '3mm板', '4mm板', '5mm板', '5mm/7mm', '7mm板', '8mm板',
            'ABS', '铁', '铝', '玻纤', '粗毛', '羽毛', '轴承',
            '双面牛筋胶皮+8mm板', '牛筋胶皮 8mm板',
        ];

        // Translate each material value in the content
        foreach ( $materials as $material ) {
            $translated = sw_t( $material, $material );
            if ( $translated !== $material ) {
                $content = str_replace( $material, $translated, $content );
            }
        }

        // Translate price values in content
        $content = sw_translate_price( $content );

        // Translate quantity values in content
        $content = sw_translate_quantity( $content );
    }
    return $content;
} );

/**
 * Filter excerpt to translate material values and prices.
 */
add_filter( 'the_excerpt', function ( $excerpt ) {
    if ( is_post_type_archive( 'product' ) || is_tax( 'product_category' ) ) {
        // Get all material values
        $materials = [
            '橡胶', '塑料', 'PP 塑料', 'PP+TPA弹簧', 'pp+弹簧+单吸卡',
            'pp塑料+布', 'pp弹簧海绵', '尼龙', '尼龙球', 'pu尼龙球',
            '仿尼龙球', '发光尼成球', '台纤尼龙球', '快速尼龙球', '防风尼龙球',
            '塑料球', '塑料棉胶', '木', '杨木', '杨木+5mm板', '杨木+7mm板',
            '3mm板', '4mm板', '5mm板', '5mm/7mm', '7mm板', '8mm板',
            'ABS', '铁', '铝', '玻纤', '粗毛', '羽毛', '轴承',
            '双面牛筋胶皮+8mm板', '牛筋胶皮 8mm板',
        ];

        // Translate each material value in the excerpt
        foreach ( $materials as $material ) {
            $translated = sw_t( $material, $material );
            if ( $translated !== $material ) {
                $excerpt = str_replace( $material, $translated, $excerpt );
            }
        }

        // Translate price values in excerpt
        $excerpt = sw_translate_price( $excerpt );

        // Translate quantity values in excerpt
        $excerpt = sw_translate_quantity( $excerpt );
    }
    return $excerpt;
} );

/**
 * Filter image URLs to encode Chinese characters.
 * This fixes issues with PHP built-in server not serving files with Chinese characters.
 */
add_filter( 'wp_get_attachment_url', function ( $url ) {
    // Encode Chinese characters in the URL
    $parts = parse_url( $url );
    if ( isset( $parts['path'] ) ) {
        $path = $parts['path'];
        // Encode Chinese characters (non-ASCII)
        $encoded_path = preg_replace_callback( '/[^\x20-\x7E]/', function ( $matches ) {
            return rawurlencode( $matches[0] );
        }, $path );
        $url = str_replace( $path, $encoded_path, $url );
    }
    return $url;
} );
