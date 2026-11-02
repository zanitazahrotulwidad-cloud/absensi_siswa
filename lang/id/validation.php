
<?php

return [
    'required' => ':attribute wajib diisi.',
    'string' => ':attribute harus berupa teks.',
    'max' => [
        'string' => ':attribute maksimal :max karakter.',
    ],
    'unique' => ':attribute sudah digunakan.',
    'date' => ':attribute harus berupa tanggal yang valid.',
    'in' => 'Pilihan :attribute tidak valid.',
    'email' => ':attribute harus berupa alamat email yang valid.',
    'min' => [
        'string' => ':attribute minimal :min karakter.',
    ],
    'attributes' => [
        'nip' => 'NIP',
        'nama' => 'nama guru',
        'jenis_kelamin' => 'jenis kelamin',
        'tanggal_lahir' => 'tanggal lahir',
        'alamat' => 'alamat',
        'email' => 'email',
        'password' => 'kata sandi',
    ],
];
