<?php
/**
 * Twenty Twenty-Five functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

// Adds theme support for post formats.
if ( ! function_exists( 'twentytwentyfive_post_format_setup' ) ) :
	/**
	 * Adds theme support for post formats.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_post_format_setup() {
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_post_format_setup' );

// Enqueues editor-style.css in the editors.
if ( ! function_exists( 'twentytwentyfive_editor_style' ) ) :
	/**
	 * Enqueues editor-style.css in the editors.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_editor_style() {
		add_editor_style( get_parent_theme_file_uri( 'assets/css/editor-style.css' ) );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_editor_style' );

// Enqueues style.css on the front.
if ( ! function_exists( 'twentytwentyfive_enqueue_styles' ) ) :
	/**
	 * Enqueues style.css on the front.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_enqueue_styles() {
		wp_enqueue_style(
			'twentytwentyfive-style',
			get_parent_theme_file_uri( 'style.css' ),
			array(),
			wp_get_theme()->get( 'Version' )
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'twentytwentyfive_enqueue_styles' );

// Registers custom block styles.
if ( ! function_exists( 'twentytwentyfive_block_styles' ) ) :
	/**
	 * Registers custom block styles.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_block_styles() {
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'twentytwentyfive' ),
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_block_styles' );

// Registers pattern categories.
if ( ! function_exists( 'twentytwentyfive_pattern_categories' ) ) :
	/**
	 * Registers pattern categories.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_pattern_categories() {

		register_block_pattern_category(
			'twentytwentyfive_page',
			array(
				'label'       => __( 'Pages', 'twentytwentyfive' ),
				'description' => __( 'A collection of full page layouts.', 'twentytwentyfive' ),
			)
		);

		register_block_pattern_category(
			'twentytwentyfive_post-format',
			array(
				'label'       => __( 'Post formats', 'twentytwentyfive' ),
				'description' => __( 'A collection of post format patterns.', 'twentytwentyfive' ),
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_pattern_categories' );

// Registers block binding sources.
if ( ! function_exists( 'twentytwentyfive_register_block_bindings' ) ) :
	/**
	 * Registers the post format block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_register_block_bindings() {
		register_block_bindings_source(
			'twentytwentyfive/format',
			array(
				'label'              => _x( 'Post format name', 'Label for the block binding placeholder in the editor', 'twentytwentyfive' ),
				'get_value_callback' => 'twentytwentyfive_format_binding',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_register_block_bindings' );

// Registers block binding callback function for the post format name.
if ( ! function_exists( 'twentytwentyfive_format_binding' ) ) :
	/**
	 * Callback function for the post format name block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return string|void Post format name, or nothing if the format is 'standard'.
	 */
	function twentytwentyfive_format_binding() {
		$post_format_slug = get_post_format();

		if ( $post_format_slug && 'standard' !== $post_format_slug ) {
			return get_post_format_string( $post_format_slug );
		}
	}
endif;

// ✅ Shortcode: [lead_form]
function lead_submission_form_shortcode() {
    ob_start();
    ?>
    <!-- ✅ Lead Form -->
    <form id="leadForm" class="lead-form" style="max-width:500px;margin:20px auto;">
        <input type="text" name="name" placeholder="Name" required><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="tel" name="phone" placeholder="Phone Number" required><br><br>
        <input type="text" name="source" value="<?php echo esc_attr($_GET['utm_campaign'] ?? 'googleads'); ?>">
        <textarea name="message" placeholder="Message"></textarea><br><br>
        <button type="submit">Submit</button>
        <div class="loader" style="display:none;text-align:center;margin-top:10px;">
            <svg xmlns="http://www.w3.org/2000/svg" style="margin:auto;background:none;display:block;" width="40px" height="40px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
              <circle cx="50" cy="50" fill="none" stroke="#0073aa" stroke-width="10" r="35" stroke-dasharray="164.93361431346415 56.97787143782138">
                <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"/>
              </circle>
            </svg>
        </div>
    </form>

    <!-- ✅ Styles -->
    <style>
        .lead-form input, .lead-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .lead-form button {
            background-color: #0073aa;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .lead-form button:hover {
            background-color: #005f8d;
        }
    </style>

    <!-- ✅ SweetAlert + Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('leadForm');
        const loader = form.querySelector('.loader');

        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            loader.style.display = 'block';

            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());

            // ✅ Client-side validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const phoneRegex = /^[0-9\-\+\s]{6,15}$/;

            if (!data.name || !emailRegex.test(data.email) || !phoneRegex.test(data.phone)) {
                loader.style.display = 'none';
                Swal.fire({
                    icon: 'error',
                    title: 'Validation failed',
                    text: 'Please fill in your name, valid email, and correct mobile number.',
                });
                return;
            }

            try {
                const response = await fetch('http://localhost:8000/api/leads', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer secret_token_123',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                loader.style.display = 'none';

                if (response.status === 201) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Data sent successfully!',
                    });
                    form.reset();
                } else {
                    const res = await response.json();
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed to send!',
                        text: res.message || 'An error occurred on the server.',
                    });
                }

            } catch (err) {
                loader.style.display = 'none';
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Connection failed',
                    text: 'Unable to contact API server.',
                });
            }
        });
    });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('lead_form', 'lead_submission_form_shortcode');




