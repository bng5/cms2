<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fn="http://www.w3.org/2005/02/xpath-functions">
<!-- xsl:output method="xml" indent="yes" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN"/ -->
<xsl:template match="/xml">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><xsl:value-of select="consulta/seccion" /></title>
<style type="text/css">
body {
	margin:0;
	background-color:#ffffff;
}
table {
	border-collapse:collapse;
}
th {
	background-color:#ccc;
	border:1px solid #efefef;
}
td {
	padding:3px;
	border-bottom:1px solid #efefef;
}
</style>
</head>
<body>
<table>
<xsl:apply-templates select="itemsEncabezado"/>
<xsl:apply-templates select="itemsLista"/>
</table>

<!-- table>
<thead>
 <tr>
<xsl:for-each select="itemsEncabezado/item/*">
 <th><xsl:value-of select="." /></th>
</xsl:for-each>
 </tr>
</thead>
<tbody>
<xsl:for-each select="//item">
 <tr>
 <td><img>
      <xsl:attribute name="src">
        <xsl:value-of select="imagen/@archivo" />
      </xsl:attribute>
      <xsl:attribute name="alt">
        <xsl:value-of select="imagen/texto" />
      </xsl:attribute>
</img></td>
  <td><a>
 <xsl:attribute name="href">/item/<xsl:value-of select="@xml:id" /></xsl:attribute>
  <xsl:value-of select="texto[@atributo='titulo']" />
 </a></td>
 <td>
 <a>
 <xsl:attribute name="href">/item/<xsl:value-of select="texto[@atributo='marca']/@valor" /></xsl:attribute>
 <xsl:value-of select="texto[@atributo='marca']" />
</a></td>
 <td><xsl:value-of select="texto[@atributo='modelo']" /></td>
 <td><xsl:value-of select="areadetexto" /></td>
</tr>
</xsl:for-each>
</tbody>
</table>




<xsl:for-each select="//item">

<h2>
 <a>
 <xsl:attribute name="href">/item/<xsl:value-of select="@xml:id" /></xsl:attribute>
  <xsl:value-of select="texto[@atributo='titulo']" />
 </a></h2>
<h4>
<a>
 <xsl:attribute name="href">/item/<xsl:value-of select="texto[@atributo='marca']/@valor" /></xsl:attribute>
 <xsl:value-of select="texto[@atributo='marca']" />
</a> - <xsl:value-of select="texto[@atributo='modelo']" />
</h4>

<img>
      <xsl:attribute name="src">
        <xsl:value-of select="imagen/@archivo" />
      </xsl:attribute>
      <xsl:attribute name="alt">
        <xsl:value-of select="imagen/texto" />
      </xsl:attribute>
</img>
<p>
<xsl:value-of select="areadetexto" />
</p>

<hr />
</xsl:for-each -->

</body>
</html>

</xsl:template>


<xsl:template match="itemsLista">
 <tbody xmlns="http://www.w3.org/1999/xhtml">
<xsl:for-each select="item">
 <tr>
 <td><img>
      <xsl:attribute name="src">
        <xsl:value-of select="imagen/archivo[@disp='miniatura']" />
      </xsl:attribute>
      <xsl:attribute name="alt">
        <xsl:value-of select="imagen/texto" />
      </xsl:attribute>
</img></td>
  <td><a>
 <xsl:attribute name="href">/item/<xsl:value-of select="@xml:id" /></xsl:attribute>
  <xsl:value-of select="texto[@atributo='titulo']" />
 </a></td>
 <td>
 <a>
 <xsl:attribute name="href">/item/<xsl:value-of select="texto[@atributo='marca']/@valor" /></xsl:attribute>
 <xsl:value-of select="texto[@atributo='marca']" />
</a></td>
 <td><xsl:value-of select="texto[@atributo='modelo']" /></td>
 <td><xsl:value-of select="texto[@atributo='descripcion']" /></td>
</tr>
</xsl:for-each>
</tbody>
</xsl:template>


<xsl:template match="itemsEncabezado">
 <thead xmlns="http://www.w3.org/1999/xhtml">
  <tr>
   <th><a>
    <xsl:attribute name="href">a4.xml<xsl:value-of select="texto[@atributo='marca']/@valor" /></xsl:attribute>
    <xsl:value-of select="item/foto" /></a></th>
   <th><a><xsl:value-of select="item/titulo" /></a></th>
   <th><a><xsl:value-of select="item/marca" /></a></th>
   <th><a><xsl:value-of select="item/modelo" /></a></th>
   <th><a><xsl:value-of select="item/descripcion" /></a></th>
 </tr>
 </thead>
</xsl:template>



</xsl:stylesheet>