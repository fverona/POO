<?php
class A 
{
	public static function quiEstCe()
	{
		echo 'A';
	} 

	public static function appelerQuiEstce()
	{
		static::quiEstCe();
	} 	

}

class B extends A
{
	public static function quiEstCe()
	{
		echo 'B';
	}

	public static function test()
	{
		self::appelerQuiEstCe();

	}
}

class C extends B
{
	public static function quiEstCe()
	{
		echo 'C';
	}
}

C::test();