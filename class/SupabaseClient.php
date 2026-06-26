<?php

require_once __DIR__ . '/../supabase.php';

class SupabaseClient {
    private string $url;
    private string $key;

    public function __construct(bool $useServiceRole = false) {
        $this->url = rtrim(SUPABASE_URL, '/') . '/rest/v1';
        $this->key = $useServiceRole ? SUPABASE_SERVICE_ROLE_KEY : SUPABASE_ANON_KEY;
    }

    private function headers(): array {
        return [
            "apikey: $this->key",
            "Authorization: Bearer $this->key",
            "Content-Type: application/json",
            "Accept: application/json",
            "Prefer: return=representation",
        ];
    }

    private function request(string $method, string $path, ?array $body = null): ?array {
        $url = $this->url . $path;

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $this->headers(),
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);

        if ($body !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode < 200 || $httpCode >= 300) {
            return null;
        }

        if ($response === false || $response === '') {
            return [];
        }

        $decoded = json_decode($response, true);
        return $decoded ?? [];
    }

    public function select(string $table, string $columns = '*', array $filters = [], string $order = ''): ?array {
        $params = ["select=" . str_replace(', ', ',', $columns)];

        foreach ($filters as $column => $value) {
            if ($value === null) {
                $params[] = urlencode($column) . '=is.null';
            } else {
                $params[] = urlencode($column) . '=eq.' . urlencode((string)$value);
            }
        }

        if ($order) {
            $params[] = "order=$order";
        }

        $query = '?' . implode('&', $params);
        return $this->request('GET', "/$table$query");
    }

    public function selectOne(string $table, string $columns = '*', array $filters = []): ?array {
        $result = $this->select($table, $columns, $filters);
        return ($result && count($result) > 0) ? $result[0] : null;
    }

    public function insert(string $table, array $data): ?array {
        return $this->request('POST', "/$table", $data);
    }

    public function update(string $table, array $data, array $filters): ?array {
        $params = [];
        foreach ($filters as $column => $value) {
            $params[] = urlencode($column) . '=eq.' . urlencode((string)$value);
        }
        $query = '?' . implode('&', $params);
        return $this->request('PATCH', "/$table$query", $data);
    }

    public function delete(string $table, array $filters): ?array {
        $params = [];
        foreach ($filters as $column => $value) {
            $params[] = urlencode($column) . '=eq.' . urlencode((string)$value);
        }
        $query = '?' . implode('&', $params);
        return $this->request('DELETE', "/$table$query");
    }

    public function raw(string $method, string $endpoint, ?array $body = null): ?array {
        return $this->request($method, $endpoint, $body);
    }
}
