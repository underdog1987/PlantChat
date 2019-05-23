<?php
interface Collection{
	public function add($object);
	public function addFromArray($a);
	public function isEmpty();
	public function clear();
	public function remove($index);
	public function leave($index);
	public function size();
	public function toArray();
	public function getItem($index);
}
?>