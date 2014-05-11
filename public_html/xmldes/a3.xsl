<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/xml">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
body {
height:100%;
}
</style>
</head>
<body>

<xsl:for-each select="item">

    <xsl:for-each select="*">
<p><xsl:value-of select="@atributo" /></p>
    </xsl:for-each>


    <!-- xsl:for-each select="imagen">
<img>
      <xsl:attribute name="src">
        <xsl:value-of select="@archivo" />
      </xsl:attribute>
      <xsl:attribute name="alt">
        <xsl:value-of select="texto" />
      </xsl:attribute>
</img>
    </xsl:for-each -->


</xsl:for-each>

</body>
</html>

</xsl:template>
</xsl:stylesheet>