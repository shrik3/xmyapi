<?php
/**
 * Created by PhpStorm.
 * User: shrik3
 * Date: 4/23/17
 * Time: 7:48 PM
 */

namespace app\Traits;


Trait CommunityTools {

    public function ge_icon_path($community_id) {
        $icon = \App\Photo::select('file_name')
            ->where([
                'owner_id' => $community_id,
                'type' => 'CommunityIcon'
            ])
            ->first();
        $url = url('images/' . $icon['file_name']);
        return $url;
    }
}