<?php

namespace Fire\Admin;

class RelativeUrls
{
    protected $domain;

    public function __construct()
    {
        $this->domain = $_SERVER['SERVER_NAME'];

        // Posts
        add_filter('wp_insert_post_data', function ($data, $post) {
            $data['post_content'] = $this->replaceDomain($data['post_content']);
            $data['post_excerpt'] = $this->replaceDomain($data['post_excerpt']);
            $data['guid']         = $this->replaceDomain($data['guid']);

            return $data;
        }, null, 2);

        add_action('wp_insert_post', function ($id, $post, $update) {
            global $wpdb;

            if ($post->post_type !== 'revision' and $post->post_status !== 'auto-draft') {
                return;
            }

            if (strpos($post->guid, $this->domain) !== false) {
                $guid = $this->replaceDomain($post->guid);

                $wpdb->update($wpdb->posts, ['guid' => $guid], ['ID' => $id]);
            }
        }, null, 3);

        // Meta
        add_actions('added_post_meta updated_post_meta', function ($id, $objectId, $key, $value) {
            $this->replaceDomainInMeta('post', $id, $objectId, $key, $value);
        }, null, 4);

        add_actions('added_user_meta updated_user_meta', function ($id, $objectId, $key, $value) {
            $this->replaceDomainInMeta('user', $id, $objectId, $key, $value);
        }, null, 4);

        add_actions('added_comment_meta updated_comment_meta', function ($id, $objectId, $key, $value) {
            $this->replaceDomainInMeta('comment', $id, $objectId, $key, $value);
        }, null, 4);

        // Options
        add_action('added_option', function ($option, $value) {
            $this->replaceDomainInOption($option, $value);
        }, null, 2);

        add_action('updated_option', function ($option, $old_value, $value) {
            $this->replaceDomainInOption($option, $value);
        }, null, 3);
    }

    public function replaceDomainInMeta($type, $id, $objectId, $key, $value)
    {
        global $wpdb;

        $table  = _get_meta_table($type);
        $column = sanitize_key($type.'_id');

        $newValue = $this->replaceDomainRecursive($value);

        if ($value !== $newValue) {
            $newValue = maybe_serialize($newValue);

            $data = ['meta_value' => $newValue];

            $where = [
                $column      => $objectId,
                'meta_key'   => $key,
                'meta_value' => $value,
            ];

            $wpdb->update($table, $data, $where);
        }
    }

    public function replaceDomainInOption($option, $value)
    {
        global $wpdb;

        if ( ! $wpdb instanceof wpdb) {
            return;
        }

        $newValue = $this->replaceDomainRecursive($value);

        if ($value !== $newValue) {
            $serialized = maybe_serialize($value);

            $wpdb->update($wpdb->options, ['option_value' => $serialized], ['option_name' => $option]);

            wp_cache_set($option, $serialized, 'options');
        }
    }

    protected function replaceDomainRecursive($value)
    {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $value[$k] = $this->replaceDomainRecursive($v);
            }
        } elseif ( ! is_object($value)) {
            if (strpos($value, $this->domain) !== false) {
                $value = $this->replaceDomain($value);
            }
        }

        return $value;
    }

    public function replaceDomain($value)
    {
        $normal_urls = 'http://'.$this->domain;
        $secure_urls = 'https://'.$this->domain;

        $value = str_replace($normal_urls, '', $value);
        $value = str_replace($secure_urls, '', $value);

        return $value;
    }
}
