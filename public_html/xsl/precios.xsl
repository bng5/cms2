<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fn="http://www.w3.org/2005/02/xpath-functions">
<!-- xsl:output method="xml" indent="yes" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN"/ -->
<xsl:template match="/xml">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Idiomas - <xsl:value-of select="cabeceras/respuesta/sitio" /></title>
</head>
<body>
<h1><xsl:value-of select="cabeceras/respuesta/sitio" /></h1>
<ul>
<xsl:for-each select="itemsLista/item">
 <li><a>
 <xsl:attribute name="href">/xml/secciones/<xsl:value-of select="./@xml:id" />?modo=xsl</xsl:attribute>
 <xsl:value-of select="texto" />
	 </a></li>
</xsl:for-each>
</ul>
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

</xsl:stylesheet>