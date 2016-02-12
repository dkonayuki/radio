<?php

namespace App\Helpers\Transformers;

class RadioTransformer extends Transformer {

    public function transform($radio) {
        return [
            'id'            => $radio['id'],
            'name'          => $radio['name'],
            'description'   => $radio['description'],
            'logo_url'      => $radio['logo_url'],
            'stream_url'    => $radio['stream_url'],
            'website'       => $radio['website'],
            'status'        => $radio['status']
        ];

    }

}
