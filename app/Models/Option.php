<?php

/**
 * DocedFrame
 * Option.php
 * Versiyon: 1.0
 * Tarih: 03.05.2026
 */

namespace App\Models;

use Core\Model;

class Option extends Model
{
	protected $table = 'options';
	
	public function get($key)
	{
		$result = $this->where('option_key', $key);
		if ($result) {
			return $result[0]['option_value'];
		}
		return null;
	}
	
	public function set($key, $value)
	{
		$existing = $this->where('option_key', $key);
		
		if ($existing) {
			$this->update($existing[0]['id'], ['option_value' => $value]);
		} else {
			$this->insert(['option_key' => $key, 'option_value' => $value]);
		}
		
		return true;
	}
}